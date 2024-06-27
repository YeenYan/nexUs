<?php

namespace App\Models;

use Tuupola\Base62;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workspace extends Model
{
    use HasFactory;

    // This tells the model that your key is a type of string and not an integer (UUIDs are strings).
    protected $keyType = 'string';
    protected $primaryKey = 'workspace_id';

    // tell the model not to use the incrementing system for this type of key
    public $incrementing = false;

    protected $fillable = [
        'workspace_id',
        'workspace_name',
        'avatar',
        'created_by',
        'active'
    ];

    /**
     * Automatically generate a UUID for the user_id when creating a new user
     * Concatinating the username to the user_id
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $uuid = (string) Str::uuid();
                $shortUuid = self::shortenUuid($uuid);
                $model->{$model->getKeyName()} = 'wp-' . $shortUuid;
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


    /**
     * Relationship where the Workspace belongs to an owner (user)
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'user_id'
        );
    }

    /**
     * Relationship where the Workspace has many Collections
     */
    public function collections(): HasMany
    {
        return $this->hasMany(
            \App\Models\Collection::class,
            'workspace_id'
        );
    }
}
