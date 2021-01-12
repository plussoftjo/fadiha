<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected  $fillable = ['user_id','posts_id','comment'];
    public $with = ['User'];

    public function User() {
        return $this->belongsTo('App\Models\User');
    }
}
