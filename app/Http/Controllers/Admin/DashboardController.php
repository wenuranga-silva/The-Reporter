<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function getData(Request $request)
    {

        $request->validate([
            '_key' => ['required', 'string', 'max:20']
        ]);

        $key = $request->_key;


        if ($key == 'ViewsMonths') {

            /// return View Count and Related Months
            $data = News::select(
                DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                DB::raw('COALESCE(sum(views), 0) as _count')
            )
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        } else if ($key == 'ViewsCat') {

            /// return View Count and Related Category
            $data = News::select(
                DB::raw('DATE_FORMAT(created_at, "%M") as month'),
                DB::raw('COALESCE(sum(views), 0) as _count')
            )
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        return response()->json(['data' => $data]);
    }
}
