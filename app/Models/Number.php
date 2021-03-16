<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Company;
use App\Models\Invoice;

class Number extends Model
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
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
