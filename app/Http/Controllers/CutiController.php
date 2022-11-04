<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeLeave;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CutiController extends Controller
{
    public function index()
    {
        
        $data = [
            'title'   				=> 'Cuti',
            'content' 				=> 'cuti'
        ];

        return view('layouts.index', ['data' => $data]);    
    }

    public function datatable(Request $request)
    {
        $column = [
            'id',
            'no',
            'date_leave',
			'date_count',
			'note'
        ];

        $start  = $request->start;
        $length = $request->length;
        $order  = $column[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $total_data = EmployeeLeave::count();
        
        $query_data = EmployeeLeave::where(function($query) use ($search) {
                if($search) {
                    $query->whereHas('employee', function($query) use ($search) {
                        $query->where('no', 'like', "%$search%")
                        ->where('name', 'like', "%$search%");
                    })
                   ->orWhere('date_leave','like',"%$search%")
                   ->orWhere('date_count','like',"%$search%")
                   ->orWhere('note','like',"%$search%");
                }
            })
            ->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $total_filtered = EmployeeLeave::where(function($query) use ($search) {
                if($search) {
                    $query->whereHas('employee', function($query) use ($search) {
                        $query->where('no', 'like', "%$search%")
                        ->where('name', 'like', "%$search%");
                    })
                   ->orWhere('date_leave','like',"%$search%")
                   ->orWhere('date_count','like',"%$search%")
                   ->orWhere('note','like',"%$search%");
                }
            })
            ->count();

        $response['data'] = [];
        if($query_data <> FALSE) {
            $nomor = $start + 1;
			
            foreach($query_data as $val) {
				
                $response['data'][] = [
					$nomor,
                    $val->employee->no,
                    date('d M Y',strtotime($val->date_leave)),
                    $val->date_count.' Hari',
                    $val->note,
                    '
                    <a href="javascript:void(0);" class="btn btn-info btn-round btn-fab btn-fab-mini edit" data-id="'.$val->id.'"><i class="material-icons">mode_edit_outline</i></a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-round btn-fab btn-fab-mini remove" data-id="'.$val->id.'"><i class="material-icons">delete</i></a>
                    '
                ];

                $nomor++;
            }
        }

        $response['recordsTotal'] = 0;
        if($total_data <> FALSE) {
            $response['recordsTotal'] = $total_data;
        }

        $response['recordsFiltered'] = 0;
        if($total_filtered <> FALSE) {
            $response['recordsFiltered'] = $total_filtered;
        }

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'karyawan'       	=> 'required',
            'tanggal_cuti'    	=> 'required',
            'jumlah_hari'		=> 'required',
            'keterangan'	    => 'required'
        ], [
            'karyawan.required'         => 'Karyawan harus diisi.',
            'tanggal_cuti.required'     => 'Tanggal cuti harus diisi.',
            'jumlah_hari.required'      => 'Jumlah hari harus diisi.',
            'keterangan.required'       => 'Keterangan harus diisi.'
        ]);

        if($validation->fails()) {
            $response = [
                'status' => 422,
                'error'  => $validation->errors()
            ];
        } else {
            
            if($request->temp){
                $query = EmployeeLeave::find($request->temp)->update([
                    'employee_id'   => $request->karyawan,
                    'date_leave'    => $request->tanggal_cuti,
                    'date_count'    => $request->jumlah_hari,
                    'note'          => $request->keterangan
                ]);
            }else{
                $query = EmployeeLeave::create([
                    'employee_id'   => $request->karyawan,
                    'date_leave'    => $request->tanggal_cuti,
                    'date_count'    => $request->jumlah_hari,
                    'note'          => $request->keterangan
                ]);
            }

            if($query) {
                $response = [
                    'status'  => 200,
                    'message' => 'Data berhasil ditambahkan.'
                ];
            } else {
                $response = [
                    'status'  => 500,
                    'message' => 'Data gagal ditambahkan.'
                ];
            }
        }

        return response()->json($response);
    }

    public function get(Request $request)
    {
        $data = EmployeeLeave::find($request->id);

        $result = [
            'id_karyawan'           => $data->employee_id,
            'detail_karyawan'       => $data->employee->name.' No. Induk : '.$data->employee->no,
            'tanggal_cuti'          => $data->date_leave,
            'jumlah_hari'           => $data->date_count,
            'keterangan'            => $data->note
        ];  

        return response()->json($result);
    }

    public function destroy(Request $request)
    {
        $query = EmployeeLeave::find($request->id)->delete();
        
        if($query) {
            $response = [
                'status'  => 200,
                'message' => 'Data berhasil dihapus.'
            ];
        } else {
            $response = [
                'status'  => 500,
                'message' => 'Data gagal dihapus.'
            ];
        }

        return response()->json($response);
    }
}
