<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{

    use HasFactory;

    protected $table      = 'employee';
    protected $primaryKey = 'id';
    protected $fillable   = [
        'no',
        'name',
        'address',
        'date_birth',
        'date_join'
    ];
    
    public function leave()
    {
        return $this->hasMany('App\Models\EmployeeLeave');
    }

    public function sisaCuti()
    {
        $totalCuti = 12;

        foreach($this->leave as $row){
          $totalCuti -= $row->date_count;
        }

        return $totalCuti;
    }
}
