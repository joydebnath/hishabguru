<?php

namespace App\Http\Controllers\Expense;

use App\Filters\Expense\OtherExpenseFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\OtherExpenseRequest;
use App\Http\Resources\Expense\OtherExpenseCollection;
use App\Models\OtherExpense;
use Exception;

class OtherExpenseController extends Controller
{
    public function index(OtherExpenseFilter $filters)
    {
        try {
            return new OtherExpenseCollection(OtherExpense::filter($filters)->paginate());
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(OtherExpenseRequest $request)
    {
        try {

        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(OtherExpense $otherExpense)
    {
        try {

        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(OtherExpenseRequest $request, OtherExpense $otherExpense)
    {
        try {

        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(OtherExpense $otherExpense)
    {
        try {

        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    private function getExpenseFillable($fillable)
    {

    }
}
