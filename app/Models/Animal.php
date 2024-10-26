<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id']; // Voeg user_id toe aan fillable

    public function user()
    {
        return $this->belongsTo(User::class); // Relatie met de User
    }


}
