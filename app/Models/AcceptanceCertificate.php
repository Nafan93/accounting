<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;

class AcceptanceCertificate extends Model
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
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
