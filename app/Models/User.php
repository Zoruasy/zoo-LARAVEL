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


public function isAdmin(): bool
{
return $this->is_admin; // kijken of admin wel op admin staat
}



}
