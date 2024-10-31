<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

class User extends Authenticatable
{
use HasFactory, Notifiable;

protected $fillable = [
'name',
'email',
'password',
'is_admin', // Add this property to allow mass assignment
// 'role', // Comment this out if not needed, or include if you're using roles
];

protected $hidden = [
'password',
'remember_token',
];

protected $casts = [
'email_verified_at' => 'datetime',
'is_admin' => 'boolean', // Cast is_admin to boolean
'password' => 'hashed',
];

// Method to check if the user is an admin
public function isAdmin(): bool
{
return $this->is_admin; // This will now work correctly
}
}
