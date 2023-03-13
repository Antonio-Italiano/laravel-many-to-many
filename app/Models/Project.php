<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'slug', 'url', 'is_published', 'type_id'];

    //Assegno la relazione con le tipologie
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    //Assegno la relazione con le Tecnologie
    public function Technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
}
