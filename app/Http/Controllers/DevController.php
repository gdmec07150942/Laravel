<?php

namespace App\Http\Controllers;

use App\Exports\SqlExport;
use App\Models\SqlLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

// Import Excel facade

class DevController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('dev.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|mixed
     */
    public function executeSql(Request $request)
    {
        $this->validate($request, [
            'sql' => 'required|string',
        ]);

        $sql = filter_var($request->input('sql'), FILTER_SANITIZE_STRING);
        $page = $request->input('page', 1);
        $user = auth()->user(); // get login user
        $perPage = 10;  // Number of rows per page
        $result = [];
        $error = null;

        try {
            $results = DB::select($sql);
            // Check if export requested
            if ($request->has('export_excel')) {
                return $this->exportToExcel($results);
            } elseif ($request->has('export_json')) {
                return response()->json($results);
            }

            $result = $this->paginate($results, $perPage, $page);
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        // record log
        SqlLog::query()->create([
            'user_id' => $user->id,
            'sql_query' => $sql,
            'error_message' => $error,
        ]);

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

    /**
     * @param $data
     * @return mixed
     */
    private function exportToExcel($data)
    {
        // Example using Maatwebsite Excel package
        return Excel::download(new SqlExport($data), 'sql_export.xlsx');
    }
}

