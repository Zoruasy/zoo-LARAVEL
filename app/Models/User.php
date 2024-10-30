<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
use HasFactory, Notifiable;

protected $fillable = [
'name',
'email',
'password',
'role', // Voeg dit toe als je een rol kolom hebt
];

protected $hidden = [
'password',
'remember_token',
];

protected function casts(): array
{
return [
'email_verified_at' => 'datetime',
'password' => 'hashed',
];
}

// Voeg hier de isAdmin-methode toe
public function isAdmin(): bool
{
return $this->is_admin; // Zorg ervoor dat deze kolom bestaat in je users tabel
}

// Voeg de relatie voor favorieten toe
public function favorites()
{
return $this->belongsToMany(Animal::class, 'favorite_animals', 'user_id', 'animal_id');
}
}
