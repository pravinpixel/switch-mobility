<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function user(){
        return $this->hasOne(User::class, 'emp_id', 'id');
    }
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
