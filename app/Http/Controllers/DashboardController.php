<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DashboardController extends Controller
{
    public function index()
    {

        $karyawanPertamaGabung = Employee::orderBy('date_join','ASC')->limit(3)->get();
        $karyawanPernahMengambilCuti = EmployeeLeave::all();
        $karyawanLebihSatuCuti = EmployeeLeave::select('employee_id')->groupBy('employee_id')->havingRaw('COUNT(*) > ?', [1])->get();
        $karyawanCutiLebihDariSatu = EmployeeLeave::whereIn('employee_id',$karyawanLebihSatuCuti)->get();
        $karyawanSisaCuti = Employee::all();
        
        $data = [
            'title'   				        => 'Dashboard',
            'karyawanPertamaGabung'         => $karyawanPertamaGabung,
            'karyawanPernahMengambilCuti'   => $karyawanPernahMengambilCuti,
            'karyawanCutiLebihDariSatu'     => $karyawanCutiLebihDariSatu,
            'karyawanSisaCuti'              => $karyawanSisaCuti,
            'content' 				        => 'dashboard'
        ];

        return view('layouts.index', ['data' => $data]);    
    }
}
