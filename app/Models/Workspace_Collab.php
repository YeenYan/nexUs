<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workspace_Collab extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    protected $primaryKey = 'workspace_collab_id';

    // tell the model not to use the incrementing system for this type of key
    public $incrementing = false;

    protected $fillable = [
        'workspace_collab_id',
        'workspace_id',
        'owner_id',
        'member_id'
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
                $model->{$model->getKeyName()} = 'wc-' . $shortUuid;
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
     * Relationship where the Workspace_Collab belongs to a Workspace
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Workspace::class,
            'workspace_id'
        );
    }


    /**
     * Relationship where the Workspace_Collab has many Users
     */
    public function users(): HasMany
    {
        return $this->hasMany(
            \App\Models\User::class,
            'user_id'
        );
    }
}
