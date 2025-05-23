<?php

namespace App\Models;

use App\Models\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'publisher', 'edition', 'publication_year'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
}
