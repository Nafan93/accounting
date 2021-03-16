<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\ProductCategory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class Product extends Model
{
    use HasFactory;
    use HasSlug;
    protected $guarded = [
        '_method',
        '_token'
      ];
    public function invoice_product()
    {
        return $this->belongsTo(InvoiceProduct::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
