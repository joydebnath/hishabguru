<?php

namespace App\Models;

use App\Enums\Address\Addressable;
use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactDetailsType;
use App\Enums\EmployeeDetailsType;
use App\Traits\Contact\Employable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use Filterable;
    use Employable;

    protected $guarded = ['id'];

    public function contact_details()
    {
        return $this->hasMany(ContactDetail::class);
    }

    public function emails()
    {
        return $this->contact_details()->where('key', ContactDetailsType::EMAIL);
    }

    public function mobiles()
    {
        return $this->contact_details()->where('key', ContactDetailsType::MOBILE);
    }

    public function phones()
    {
        return $this->contact_details()->where('key', ContactDetailsType::PHONE);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'addressable_id')->where('addressable_type', Addressable::CONTACT);
    }

    public function home_address()
    {
        return $this->addresses()->where('address_type', AddressType::HOME);
    }

    public function child_contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_contacts', 'parent_contact_id', 'child_contact_id')->withTimestamps();
    }

    public function parent_contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_contacts', 'child_contact_id', 'parent_contact_id')->withTimestamps();
    }
}
