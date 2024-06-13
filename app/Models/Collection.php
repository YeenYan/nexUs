<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collection extends Model
{
    use HasFactory;

    // This tells the model that your key is a type of string and not an integer (UUIDs are strings).
    protected $keyType = 'string';
    protected $primaryKey = 'collection_id';

    protected $fillable = [
        'collection_id',
        'collection_name',
        'workspace_id'
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
                $model->{$model->getKeyName()} = 'col-' . $shortUuid;
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

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Workspace::class,
            'workspace_id'
        );
    }
}
