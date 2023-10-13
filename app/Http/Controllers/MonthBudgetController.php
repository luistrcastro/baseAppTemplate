<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonthBudgetRequest;
use App\Http\Requests\UpdateMonthBudgetRequest;
use App\Models\MonthBudget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class MonthBudgetController extends Controller
{
  protected Model $model;

  public function __contruct() 
  {
    $this->model = app(MonthBudget::class);
  }

  /**
   * Display a listing of the resource.
   * 
   * @return JsonResponse
   */
  public function index()
  {
      $result = MonthBudget::get();
      return $this->sendSuccess($result->toArray(), 'Month Budgets retrieved successfully');
  }

  /**
   * Store a newly created resource in storage.
   * 
   * @param StoreBudgetRequest $request
   * @return JsonResponse
   */
  public function store(StoreMonthBudgetRequest $request): JsonResponse
  {
    $input = $request->validated();
    $newBudget = MonthBudget::create($input);
    return $this->sendSuccess($newBudget, 'New month budget created successfully');
  }

  /**
   * Display the specified resource.
   * 
   * @param int $id
   * @return JsonResponse
   */
  public function show(int $id): JsonResponse
  {
      $result = MonthBudget::find($this->model->decodeHash($id));
      if (!$result) return $this->sendError('Month Budget not found');
      return $this->sendSuccess($result, 'Month Budget retrieved successfully');
  }

  /**
   * Update the specified resource in storage.
   * 
   * @param int $id
   * @param UpdateBudgetRequest
   * @return JsonResponse
   */
  public function update(int $id, UpdateMonthBudgetRequest $request): JsonResponse
  {
      $input = $request->validated();

      $budget = MonthBudget::find($this->model->decodeHash($id));
      if (empty($budget)) {
        return $this->sendError('Month Budget not found');
      }

      $budget->fill($input)->save();
      return $this->sendSuccess($input, 'Month Budget updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   * 
   * @param int $id
   * @return JsonResponse
   */
  public function destroy(int $id): JsonResponse
  {
      $budget = MonthBudget::find($this->model->decodeHash($id));
      if (empty($budget)) {
        return $this->sendError('Month Budget not found');
      }

      $budget->delete();
      return $this->sendSuccess([], 'Month Budget deleted successfully');
  }

      /**
   * Restores deleted categories
   * POST
   * @param int $id
   * @return JsonResponse
   */
  public function restore(int $id): JsonResponse
  {
      $budget = MonthBudget::withTrashed()->find($this->model->decodeHash($id));
      if (empty($budget)){
          return $this->sendError('Month Budget not found');
      }

      $budget->restore();
      return $this->sendSuccess($budget, 'Month Budget restored successfully');
  }
}
