<?php


namespace App\Services\PrintDoc;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use LaravelDaily\Invoices\Invoice;

class ExtendedInvoice extends Invoice
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var Collection
     */
    public $delivery_details;

    /**
     * @var Carbon
     */
    public $delivery_date;
    public $due_date;
    public $expiry_date;

    public function __construct($name = 'Invoice')
    {
        parent::__construct($name);
    }

    public function addMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function addDeliveryDetails(DeliveryDetails $details)
    {
        $this->delivery_details = $details;
        return $this;
    }

    public function addDeliveryDate(Carbon $date)
    {
        $this->delivery_date = $date;
        return $this;
    }

    public function addDueDate(Carbon $date)
    {
        $this->due_date = $date;
        return $this;
    }

    public function addExpiryDate(Carbon $date)
    {
        $this->expiry_date = $date;
        return $this;
    }

    public function getDeliveryDate()
    {
        return $this->delivery_date->format($this->date_format);
    }

    public function getDueDate()
    {
        return $this->due_date->format($this->date_format);
    }

    public function getExpiryDate()
    {
        return $this->expiry_date->format($this->date_format);
    }
}
