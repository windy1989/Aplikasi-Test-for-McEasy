<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeLeave;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index()
    {
        
        $data = [
            'title'   				=> 'Karyawan',
            'content' 				=> 'karyawan'
        ];

        return view('layouts.index', ['data' => $data]);    
    }

    public function datatable(Request $request)
    {
        $column = [
            'id',
            'no',
            'name',
			'address',
			'date_birth',
            'date_join',
        ];

        $start  = $request->start;
        $length = $request->length;
        $order  = $column[$request->input('order.0.column')];
        $dir    = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $total_data = Employee::count();
        
        $query_data = Employee::where(function($query) use ($search) {
                if($search) {
                   $query->where('no','like',"%$search%")
                   ->orWhere('name','like',"%$search%")
                   ->orWhere('address','like',"%$search%")
                   ->orWhere('date_birth','like',"%$search%")
                   ->orWhere('date_join','like',"%$search%");
                }
            })
            ->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $total_filtered = Employee::where(function($query) use ($search) {
                if($search) {
                    $query->where('no','like',"%$search%")
                    ->orWhere('name','like',"%$search%")
                    ->orWhere('address','like',"%$search%")
                    ->orWhere('date_birth','like',"%$search%")
                    ->orWhere('date_join','like',"%$search%");
                }
            })
            ->count();

        $response['data'] = [];
        if($query_data <> FALSE) {
            $nomor = $start + 1;
			
            foreach($query_data as $val) {
				
                $response['data'][] = [
					$nomor,
                    $val->no,
                    $val->name,
                    $val->address,
                    date('d M Y',strtotime($val->date_birth)),
                    date('d M Y',strtotime($val->date_join)),
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
        if($request->temp){
            $validation = Validator::make($request->all(), [
                'no_induk'     		=> ['required', Rule::unique('employee', 'no')->ignore($request->temp)],
                'nama'       		=> 'required',
                'alamat'    		=> 'required',
                'tanggal_lahir'		=> 'required',
                'tanggal_gabung'	=> 'required',
            ], [
                'no_induk.required'         => 'No induk harus diisi.',
                'no_induk.unique'           => 'No induk telah terpakai.',
                'nama.required'             => 'Nama harus diisi.',
                'alamat.required'           => 'Alamat harus diisi.',
                'tanggal_lahir.required'    => 'Tanggal lahir harus diisi.',
                'tanggal_gabung.required'   => 'Tanggal gabung harus diisi.',
            ]);
        }else{
            $validation = Validator::make($request->all(), [
                'no_induk'     		=> 'required|unique:employee,no',
                'nama'       		=> 'required',
                'alamat'    		=> 'required',
                'tanggal_lahir'		=> 'required',
                'tanggal_gabung'	=> 'required',
            ], [
                'no_induk.required'         => 'No induk harus diisi.',
                'no_induk.unique'           => 'No induk telah terpakai.',
                'nama.required'             => 'Nama harus diisi.',
                'alamat.required'           => 'Alamat harus diisi.',
                'tanggal_lahir.required'    => 'Tanggal lahir harus diisi.',
                'tanggal_gabung.required'   => 'Tanggal gabung harus diisi.',
            ]);
        }
        

        if($validation->fails()) {
            $response = [
                'status' => 422,
                'error'  => $validation->errors()
            ];
        } else {
            
            if($request->temp){
                $query = Employee::find($request->temp)->update([
                    'no'            => $request->no_induk,
                    'name'          => $request->nama,
                    'address'       => $request->alamat,
                    'date_birth'    => $request->tanggal_lahir,
                    'date_join'     => $request->tanggal_gabung
                ]);
            }else{
                $query = Employee::create([
                    'no'            => $request->no_induk,
                    'name'          => $request->nama,
                    'address'       => $request->alamat,
                    'date_birth'    => $request->tanggal_lahir,
                    'date_join'     => $request->tanggal_gabung
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
        $data = Employee::find($request->id);
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $query = Employee::find($request->id);
        EmployeeLeave::where('employee_id',$request->id)->delete();
        
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

    public function select2(Request $request){
        $response = [];
        $search   = $request->search;
        $data     = Employee::select('id', 'no', 'name')
            ->where('name', 'like', "%$search%")
			->orWhere('no', 'like', "%$search%")
            ->get();

        foreach($data as $d) {
            $response[] = [
                'id'   => $d->id,
                'text' => $d->name.' No. Induk : '.$d->no
            ];
        }

        return response()->json(['items' => $response]);
    }
}
