<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Number;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\AcceptanceCertificate;
use App\Models\User;
class Company extends Model
{
    use HasFactory;
   
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class); 
    } 
    public function acceptance_certificates() {
        return $this->hasMany(AcceptanceCertificate::class); 
    }  

    public function customers() {
        return $this->hasMany(Customer::class); 
    }
     
    public function numbers() {
        return $this->hasMany(Number::class); 
    }  
    public function products() {
        return $this->hasMany(Product::class); 
    }
    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }
    protected static function boot() {
        parent::boot();

        static::creating(function ($company) {
            $company->slug = Str::slug($company->name);
        });
    }
}