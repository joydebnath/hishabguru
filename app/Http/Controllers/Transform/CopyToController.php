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

class CopyToController extends Controller
{
    public function store()
    {
        $from = $this->getModel(request()->get('from'))::find(request()->get('copy_from_id'));
        $to = $this->getModel(request()->get('to'));
    }

    private function getModel($type): Model
    {
        if ($type === 'quotation') {
            return new Quotation;
        } elseif ($type === 'order') {
            return new Order;
        } elseif ($type === 'purchase') {
            return new Purchase;
        } elseif ($type === 'invoice') {
            return new Invoice;
        }
        throw new Exception('Unsupported model name');
    }

    private function getCopyService($type): ICopyService
    {
        if ($type === 'quotation') {
            return new CopyQuotationService;
        } elseif ($type === 'order') {
            return new CopyOrderService;
        } elseif ($type === 'purchase') {
            return new CopyPurchaseService;
        }
        throw new Exception('Unsupported model name');
    }

}
