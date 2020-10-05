<?php

namespace App\Http\Controllers\Expense;

use App\Filters\Expense\OtherExpenseFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\OtherExpenseRequest;
use App\Http\Resources\Expense\OtherExpenseCollection;
use App\Http\Resources\Expense\OtherExpenseFullResource;
use App\Models\OtherExpense;
use App\Http\Resources\Expense\OtherExpense as OtherExpenseResource;
use App\Services\Expense\OtherExpenseService;
use Exception;
use Illuminate\Support\Facades\Auth;

class OtherExpenseController extends Controller
{
    protected $service;

    public function __construct(OtherExpenseService $service)
    {
        $this->service = $service;
    }

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
            $storable = $this->getExpenseFillable($request);

            if ($request->status !== 'draft') {
                $storable['total_due'] = $request->total_amount;
            }

            $expense = OtherExpense::create($storable);

            $this->service->attachExpenseItems($expense, $request->products);

            if ($request->get('payment', null)) {
                $this->service->attachPaymentHistory(
                    $expense,
                    $request->get('payment'),
                    Auth::id()
                );
            }

            return new OtherExpenseResource($expense->fresh());
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(OtherExpense $otherExpense)
    {
        try {
            return new OtherExpenseFullResource($otherExpense->load('items', 'payable'));
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
            $otherExpense->payable()->delete();
            $otherExpense->delete();
            return response(['message' => 'Other Expense is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    private function getExpenseFillable($request): array
    {
        $fillable = $request->validated();
        unset($fillable['products']);
        unset($fillable['payment']);
        return $fillable;
    }
}
