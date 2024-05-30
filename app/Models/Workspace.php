<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workspace extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'workspace_name',
        // 'workspace_avatar',
    ];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'created_by'
        );
    }
}
