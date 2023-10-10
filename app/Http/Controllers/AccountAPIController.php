<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class AccountAPIController extends ApiBaseController
{
    protected Model $model;

    public function __construct()
    {
        $this->model = app(Account::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = Account::all();

        return $this->sendSuccess($result->toArray(), 'Accounts retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccountRequest $request
     * @return JsonResponse
     */
    public function store(StoreAccountRequest $request): JsonResponse
    {
        $input = $request->validated();
        $newAccount = Account::create($input);
        return $this->sendSuccess($newAccount, 'New account created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $result = Account::find($this->model->decodeHash($id, 'Account'));
        if (!$result) return $this->sendError('Account not found');
        return $this->sendSuccess($result, 'Account retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param UpdateAccountRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateAccountRequest $request): JsonResponse
    {
        $input = $request->validated();

        $account = Account::find($this->model->decodeHash($id));
        if (empty($account)){
            return $this->sendError('Account not found');
        }

        $account->fill($input)->save();
        return $this->sendSuccess($input, 'Account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $account = Account::find($this->model->decodeHash($id));
        if (empty($account)){
            return $this->sendError('Account not found');
        }

        $account->delete();
        return $this->sendSuccess([], 'Account deleted successfully');
    }
}
