<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'type',
        'phone_number',
        'email',
        'location',
        'address',
        'description',
        'opening_hours',
        'picture',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'type' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function coworking()
    {
        return $this->hasOne(Coworking::class, 'workspace_id');
    }

    public function studio()
    {
        return $this->hasOne(Studio::class, 'workspace_id');
    }

    public function images()
    {
        return $this->hasMany(WorkspaceImage::class, 'workspace_id');
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class, 'workspace_id');
    }

    public function reviews()
    {
        return $this->hasMany(WorkspaceReview::class, 'workspace_id');
    }

    /**
     * Accessor for the main picture URL. Converts stored path into served media URL.
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
