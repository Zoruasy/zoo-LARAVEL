<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    // Vul de velden in die massaal kunnen worden ingevuld

    protected $fillable = ['name', 'species','image_path', 'habitat','is_active', 'user_id'];


    // Relatie met de User
    public function user()
    {
        return $this->belongsTo(User::class); // Relatie met de User
    }
}
