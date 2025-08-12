<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    protected $fillable = ['product_id', 'picture'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productFeature()
    {
        return $this->hasOne(ProductFeature::class, 'image_id');
    }

    /**
     * Accessor to normalize picture URL through /media.
     */
    public function getPictureAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }
        if (is_string($value) && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
            return $value;
        }
        $relative = ltrim(preg_replace('#^/storage/#', '', (string) $value), '/');
        return url('/media/' . $relative);
    }
}
