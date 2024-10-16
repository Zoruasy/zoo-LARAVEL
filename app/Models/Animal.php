<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory; // Gebruik van de Eloquent Factory trait

    // Definieer de tabelnaam als deze niet de standaard naam volgt
    protected $table = 'zoo'; // Dit is de naam van je database tabel

    // Definieer de vulbare velden
    protected $fillable = [
        'name',
        'species',
        'habitat',
    ];


}
