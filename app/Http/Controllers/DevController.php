<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class DevController extends Controller
{
    public function index()
    {
        return view('dev.index');
    }

    public function executeSql(Request $request)
    {
        $sql = $request->input('sql');
        $page = $request->input('page', 1);
        $perPage = 10;  // Number of rows per page
        $result = [];
        $error = null;

        try {
            $results = DB::select($sql);
            $result = $this->paginate($results, $perPage, $page);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return view('dev.index', compact('result', 'error'));
    }

    /**
     * use LengthAwarePaginator
     * @param $items
     * @param $perPage
     * @param $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage, $page, $options = [])
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = is_array($items) ? collect($items) : $items;
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}

