<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profiles";
    protected $fillable = ['name', 'lastname', 'address', 'phone', 'gender', 'user_id'];

    // Relationship inverse with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
