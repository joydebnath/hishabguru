<?php

namespace App\Models;

use App\Enums\Address\Addressable;
use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactDetailsType;
use App\Enums\Payment\CreditRecordType;
use App\Traits\Contact\Employable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contact extends Model
{
    use Filterable;
    use Employable;

    protected $guarded = ['id'];

    public function tenant(): HasOne
    {
        return $this->hasOne(Tenant::class);
    }

    public function contact_details(): HasMany
    {
        return $this->hasMany(ContactDetail::class);
    }

    public function emails(): HasMany
    {
        return $this->contact_details()->where('key', ContactDetailsType::EMAIL);
    }

    public function mobiles(): HasMany
    {
        return $this->contact_details()->where('key', ContactDetailsType::MOBILE);
    }

    public function phones(): HasMany
    {
        return $this->contact_details()->where('key', ContactDetailsType::PHONE);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'addressable_id')->where('addressable_type', Addressable::CONTACT);
    }

    public function home_address(): HasMany
    {
        return $this->addresses()->where('address_type', AddressType::HOME);
    }

    public function child_contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_contacts', 'parent_contact_id', 'child_contact_id')->withTimestamps();
    }

    public function parent_contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_contacts', 'child_contact_id', 'parent_contact_id')->withTimestamps();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'contact_users')->withTimestamps();
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function bills(): HasMany
    {
        return $this->hasMany(Bill::class);
    }

    public function creditRecords(): HasMany
    {
        return $this->hasMany(ContactCreditRecord::class);
    }

    public function creditors(): HasMany
    {
        return $this->creditRecords()->where('type', CreditRecordType::CREDITOR);
    }

    public function debtors(): HasMany
    {
        return $this->creditRecords()->where('type', CreditRecordType::DEBTOR);
    }

    public function scopeTotalDueInvoiceAmount($query)
    {
        return $query->addSelect([
            'due_amount' => ContactCreditRecord::select('open_balance')
                ->whereColumn('contact_id', 'contacts.id')
                ->where('type', CreditRecordType::DEBTOR)
                ->limit(1)
        ]);
    }

    public function scopeTotalDueBillAmount($query)
    {
        return $query->addSelect([
            'due_amount' => ContactCreditRecord::select('open_balance')
                ->whereColumn('contact_id', 'contacts.id')
                ->where('type', CreditRecordType::CREDITOR)
                ->limit(1)
        ]);
    }
}
