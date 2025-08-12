<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderPicture extends Model
{
    protected $table = 'service_provider_pictures';
    protected $fillable = ['service_provider_id', 'picture'];

    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class, 'service_provider_id');
    }

    /**
     * Accessor for picture URL via /media.
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
?>
