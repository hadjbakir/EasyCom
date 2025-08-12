<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'workspace_id',
        'image_url',
    ];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'workspace_id');
    }

    /**
     * Expose full URL for image_url via /media route.
     */
    public function getImageUrlAttribute($value): ?string
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
