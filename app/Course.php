<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title','description'];

    public function users()
    {
        return $this->belongsToMany(User::class)->select('users.id','name');
    }
}
