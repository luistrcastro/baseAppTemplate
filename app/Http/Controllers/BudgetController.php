<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;
use App\Models\Budget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class BudgetController extends ApiBaseController
{
    protected Model $model;

    public function __contruct() 
    {
      $this->model = app(Budget::class);
    }

    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index()
    {
        $result = Budget::get();
        return $this->sendSuccess($result->toArray(), 'Budgets retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param StoreBudgetRequest $request
     * @return JsonResponse
     */
    public function store(StoreBudgetRequest $request): JsonResponse
    {
      $input = $request->validated();
      $newBudget = Budget::create($input);
      return $this->sendSuccess($newBudget, 'New budget created successfully');
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $result = Budget::find($this->model->decodeHash($id));
        if (!$result) return $this->sendError('Budget not found');
        return $this->sendSuccess($result, 'Budget retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param int $id
     * @param UpdateBudgetRequest
     * @return JsonResponse
     */
    public function update(int $id, UpdateBudgetRequest $request): JsonResponse
    {
        $input = $request->validated();

        $budget = Budget::find($this->model->decodeHash($id));
        if (empty($budget)) {
          return $this->sendError('Budget not found');
        }

        $budget->fill($input)->save();
        return $this->sendSuccess($input, 'Budget updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $budget = Budget::find($this->model->decodeHash($id));
        if (empty($budget)) {
          return $this->sendError('Budget not found');
        }

        $budget->delete();
        return $this->sendSuccess([], 'Budget deleted successfully');
    }

        /**
     * Restores deleted categories
     * POST
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $budget = Budget::withTrashed()->find($this->model->decodeHash($id));
        if (empty($budget)){
            return $this->sendError('Budget not found');
        }

        $budget->restore();
        return $this->sendSuccess($budget, 'Budget restored successfully');
    }
}
