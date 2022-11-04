<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class EmployeeLeave extends Authenticatable
{

    use HasFactory;

    protected $table      = 'employee_leave';
    protected $primaryKey = 'id';
    protected $fillable   = [
		'employee_id',
        'date_leave',
        'date_count',
        'note'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
    
}
