<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address', 'post', 'salary', 'status', 'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}

