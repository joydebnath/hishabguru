<?php

namespace App\Http\Controllers\Transform;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Quotation;
use App\Services\Copy\CopyOrderService;
use App\Services\Copy\CopyPurchaseService;
use App\Services\Copy\CopyQuotationService;
use App\Services\Copy\ICopyService;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Auth;

class CopyToController extends Controller
{
    public function store()
    {
        try {
            $from = $this->getModel(request()->get('from'))::find(request()->get('copy_from_id'));
            $copyService = $this->getCopyService(request()->get('from'));

            $results = [];
            foreach (request()->get('to') as $toType) {
                $result = $copyService->store($toType, $from, Auth::id());
                $results[$toType] = $this->getUrl($toType, $result);
                //$toType = orders | invoices | bills
                $from->$toType()->attach($result->id, [
                    'copy_from_type' => request()->get('from'),
                    'copy_to_type' => $toType
                ]);
            }

            return response(['data' => $results], 201);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    private function getModel($type): Model
    {
        if ($type === 'quotations') {
            return new Quotation;
        } elseif ($type === 'orders') {
            return new Order;
        } elseif ($type === 'purchases') {
            return new Purchase;
        } elseif ($type === 'invoices') {
            return new Invoice;
        }
        throw new Exception('Unsupported model name');
    }

    private function getCopyService($type): ICopyService
    {
        if ($type === 'quotations') {
            return new CopyQuotationService;
        } elseif ($type === 'orders') {
            return new CopyOrderService;
        } elseif ($type === 'purchases') {
            return new CopyPurchaseService;
        }
        throw new Exception('Unsupported model name');
    }

    /**
     * @param $item
     * @param $result
     * @return string
     */
    private function getUrl($item, $result): string
    {
        return '/@/' . $item . '/' . $result->id;
    }

}
