<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Number;
use App\Models\InvoiceProduct;
use App\Models\AcceptanceCertificate;
class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [
        '_method',
        '_token'
      ];

    public function company() 
    {
        return $this->belongsTo(Company::class);
    }  
    public function customer() 
    {
        return $this->belongsTo(Customer::class);
    }
    public function number()
    {
        return $this->hasOne(Number::class);
    }
    public function invoice_products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
    public function acceptance_certificate()
    {
        return $this->hasOne(AcceptanceCertificate::class);
    }
}
