<?php

namespace App\Services\Payment;

use App\Enums\Business\InvoiceStatus;
use App\Enums\Payment\CreditRecordType;
use App\Models\Bill;
use App\Models\ContactCreditRecord;
use App\Models\Invoice;

class CreditRecordService
{
    public function updateClientCreditRecord(Invoice $invoice)
    {
        $acceptableStatuses = [InvoiceStatus::PAID, InvoiceStatus::DUE];
        if (in_array($invoice->status, $acceptableStatuses)) {
            $openBalance = Invoice::where([
                ['tenant_id', '=', $invoice->tenant_id],
                ['contact_id', '=', $invoice->contact_id],
            ])
                ->whereIn('status', $acceptableStatuses)
                ->sum('total_due');

            ContactCreditRecord::updateOrCreate([
                'contact_id' => $invoice->contact_id,
                'type' => CreditRecordType::DEBTOR
            ], [
                'open_balance' => $openBalance
            ]);
        }
    }

    public function updateSupplierCreditRecord(Bill $bill)
    {
        $acceptableStatuses = [InvoiceStatus::PAID, InvoiceStatus::DUE];
        if (in_array($bill->status, $acceptableStatuses)) {
            $openBalance = Bill::where([
                ['tenant_id', '=', $bill->tenant_id],
                ['contact_id', '=', $bill->contact_id],
            ])
                ->whereIn('status', $acceptableStatuses)
                ->sum('total_due');

            ContactCreditRecord::updateOrCreate([
                'contact_id' => $bill->contact_id,
                'type' => CreditRecordType::CREDITOR
            ], [
                'open_balance' => $openBalance
            ]);
        }
    }
}
