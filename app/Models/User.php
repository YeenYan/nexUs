<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    // This tells the model that your key is a type of string and not an integer (UUIDs are strings).
    protected $keyType = 'string';
    protected $primaryKey = 'user_id';

    // tell the model not to use the incrementing system for this type of key
    public $incrementing = false;

    protected $appends = ['src'];

    protected $fillable = [
        'user_id',
        'username',
        'email',
        'password',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'user_id';
    }

    /**
     * This makes the password Hashed automatically before saving to the database
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value,
            set: fn($value) => Hash::make($value),
        );
    }

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
                $model->{$model->getKeyName()} = $model->username . '-' . $shortUuid;
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
     * Get the avatar attribute with the full storage path.
     *
     * This accessor automatically prepends the '/storage/avatars/' directory to the
     * avatar filename stored in the database, providing the full URL to the avatar image.
     *
     */
    public function avatar(): Attribute
    {
        return Attribute::make(get: function ($value) {
            return '/storage/avatars/' . $value;
        });
    }

    /**
     * Relationship where the user has many Workspaces
     */
    public function workspaces(): HasMany
    {
        return $this->hasMany(
            \App\Models\Workspace::class,
            'created_by'
        );
    }

    public function getSrcAttribute()
    {
        return asset("storage/{$this->avatar}");
    }
}
