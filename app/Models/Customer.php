<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Company;

class Customer extends Model
{
    use HasFactory; 
    protected $guarded = [
        '_method',
        '_token'
      ];

    public function invoices() {
          return $this->hasMany(Invoice::class); 
    } 
    public function company() 
    {
        return $this->belongsTo(Company::class);
    }  
}
