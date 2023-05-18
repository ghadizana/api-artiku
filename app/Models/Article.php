<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'synopsis', 'content', 'user_id', 'image'];

    public function writer() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
