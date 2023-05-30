<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuManager;
use DataTables;

class MasterController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = MenuManager::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex flex-row">
                                <a class="btn btn-success btn-sm" href="'.route('verifikasi.for',$row->id).'"><span class="ti ti-search"></span></a>
                                '.csrf_field().'</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.master.index');
    }
}
