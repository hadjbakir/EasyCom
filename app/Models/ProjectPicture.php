<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPicture extends Model
{
    protected $table = 'project_pictures';
    protected $fillable = ['project_id', 'picture'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
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
