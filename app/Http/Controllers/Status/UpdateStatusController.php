<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Order;
use App\Models\OtherExpenseItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function Symfony\Component\String\b;

class UpdateStatusController extends Controller
{
    public function update(Request $request, $type, $id)
    {
        try {
            $model = self::getModelInstance($type);
            $update = $model::findOrFail($id)->update(['status' => $request->status]);
            if ($update) {
                return response(['message' => 'Status updated.']);
            }
            throw new \Exception('Unable to update status.');
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    private static function getModelInstance($type): Model
    {
        if ($type == 'quotation') {
            return new Quotation;
        } elseif ($type == 'order') {
            return new Order;
        } elseif ($type == 'purchase') {
            return new Purchase;
        } elseif ($type == 'bill') {
            return new Bill;
        } elseif ($type == 'other-expense') {
            return new OtherExpenseItem;
        } elseif ($type == 'products') {
            return new Product;
        }
        throw new \Exception(b('Model not found'));
    }
}
