<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Posts extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "posts";
    protected $fillable = [
        'title',
        'news_content',
        'author',
    ];

    public function writer()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
