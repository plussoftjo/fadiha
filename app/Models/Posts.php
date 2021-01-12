<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'video',
        'post',
        'tags',
        'user_id'
    ];

    public $with = ['User','Likes','Comments'];

    public function User() {
        return $this->belongsTo('App\Models\User');
    }

    public function Likes() {
        return $this->hasMany('App\Models\Likes');
    }

    public function Comments(){
        return $this->hasMany('App\Models\Comments');
    }
}
