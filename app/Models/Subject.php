<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['description'];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
