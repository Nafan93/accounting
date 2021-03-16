<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Product;
class InvoiceProduct extends Model
{
    use HasFactory;

    protected $guarded = [
        '_method',
        '_token'
      ];
    public function invoice()
    {
        return $this->belongsTo(Invocie::class);
    }
    public function product()
    {
        return $this->hasOne(Product::class);
    }

}
