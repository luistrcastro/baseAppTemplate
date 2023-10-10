<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartAndEndDates;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\StoreTransactionBulkRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TransactionAPIController extends ApiBaseController
{
    protected Model $model;

    public function __construct()
    {
        $this->model = app(Transaction::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = Transaction::all();

        return $this->sendSuccess($result->toArray(), 'Transactions retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTransactionRequest $request
     * @return JsonResponse
     */
    public function store(StoreTransactionRequest $request): JsonResponse
    {
//        There's no need to use this, I was testing/building the hashable service method
//        $input = HashableService::decodeHashedCollection(collect($request), 'Transaction')->validated();

        $input = $request->validated();
        $newTransaction = Transaction::create($input);
        return $this->sendSuccess($newTransaction, 'New transaction created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $result = Transaction::find($this->model->decodeHash($id, 'Transaction'));
        if (!$result) return $this->sendError('Transaction not found');
        return $this->sendSuccess($result, 'Transaction retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTransactionRequest $request
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function update(int $id, UpdateTransactionRequest $request): JsonResponse
    {
        $input = $request->validated();

        $transaction = Transaction::find($this->model->decodeHash($id));
        if (empty($transaction)){
            return $this->sendError('Transaction not found');
        }

        $transaction->fill($input)->save();
        return $this->sendSuccess($input, 'Transaction updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $transaction = Transaction::find($this->model->decodeHash($id));
        if (empty($transaction)){
            return $this->sendError('Transaction not found');
        }

        $transaction->delete();
        return $this->sendSuccess([], 'Transaction deleted successfully');
    }

    /**
     * Display a listing of the resource based on start and end date.
     * POST /transactions/per_period
     * @return JsonResponse
     */
    public function perPeriod(StartAndEndDates $request): JsonResponse
    {
        $result = Transaction::whereBetween('date', [$request->start_date, $request->end_date]);
        return $this->sendSuccess($result->toArray(), 'Transactions retrieved successfully');
    }

    /**
     * Save an array of transactions. Payload => {transactions: [...]}
     * POST /transactions/bulk
     * @return JsonResponse
     */
    public function bulk(StoreTransactionBulkRequest $request): JsonResponse
    {
      $result = DB::transaction(function () use ($request) {
        $collector = [];
        foreach($request->input('transactions') as $item) {
          $collector[] = Transaction::create($item);
        }
        return $collector;
      });
      return $this->sendSuccess($result, 'New transactions created successfully');
    }
}
