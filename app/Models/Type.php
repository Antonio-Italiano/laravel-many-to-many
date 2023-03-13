<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    //Assegno la relazione con i progetti
    public function projects(){
        return $this->hasMany(Project::class);
    }
}
