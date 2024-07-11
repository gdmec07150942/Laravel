<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevController extends Controller
{
    public function index()
    {
        return view('dev.index');
    }

    public function executeSql(Request $request)
    {
        $sql = $request->input('sql');
        $result = null;
        $error = null;

        try {
            $result = DB::select(DB::raw($sql));
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return view('dev.index', compact('result', 'error'));
    }
}

