<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LaporanController extends Controller
{
    public function index()
    {
        
        $data = [
            'title'   				=> 'Dashboard',
            'content' 				=> 'laporan'
        ];

        return view('layouts.index', ['data' => $data]);    
    }
}
