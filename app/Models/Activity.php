<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    // This tells the model that your key is a type of string and not an integer (UUIDs are strings).
    protected $keyType = 'string';
    protected $primaryKey = 'activity_id';

    // Override to prevent default id auto-increment assumption
    public $incrementing = false;

    /**
     * Automatically generate a UUID for the activity_id when creating a new activity
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $uuid = (string) Str::uuid();
                $shortUuid = self::shortenUuid($uuid);
                $model->{$model->getKeyName()} = 'act-' . $shortUuid;
            }
        });
    }

    /**
     * This will shorten the generated UUID and used above
     * @return string
     */
    private static function shortenUuid($uuid)
    {
        $hex = str_replace('-', '', $uuid); // Remove hyphens
        $binary = hex2bin($hex);
        $base64 = base64_encode($binary);
        $base64Url = strtr($base64, '+/', '-_'); // Make it URL safe
        return rtrim($base64Url, '='); // Remove padding
    }


    protected $fillable = [
        'activity_id',
        'activity_name',
        'status_type',
        'priority_type',
        'due_date',
        'description',
        'task_id'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Task::class,
            'task_id'
        );
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
}
