<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name','last_name','email','mobile','sap_id','department_id','designation_id'
     ];
    public function user(){
        return $this->hasOne(User::class, 'emp_id', 'id');
    }
    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
    public function designation()
    {
        return $this->hasOne(Designation::class, 'id', 'designation_id');
    }
}
