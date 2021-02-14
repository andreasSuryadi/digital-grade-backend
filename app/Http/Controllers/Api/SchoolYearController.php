<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SchoolYear\ListSchoolYearResource;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use DB;

class SchoolYearController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'name');
        $orderDirection = $request->query('sort_order', 'desc');

        $schoolYears = SchoolYear::select(
            DB::raw('school_years.id as id'),
            'start_year',
            'end_year',
        )
            ->where('start_year', 'LIKE', '%' . $search . '%')
            ->orWhere('end_year', 'LIKE', '%' . $search . '%')
            ->groupBy('start_year', 'end_year');

        $schoolYears = $schoolYears->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListSchoolYearResource::collection($schoolYears);
    }

    public function show($id)
    {
        $schoolYear = SchoolYear::find($id);

        return response()->json($schoolYear);
    }

    public function create(Request $request)
    {
        $schoolYear = SchoolYear::orderBy('id', 'desc')->first();
        
        for ($i = 1; $i <= 2; $i++) {
            $newSchoolYear = SchoolYear::create([
                'start_year' => $schoolYear->end_year,
                'end_year' => $schoolYear->end_year + 1,
                'semester' => $i,
            ]);
        }

        return response()->json($schoolYear);
    }

    public function getSchoolYear()
    {
        $schoolYear = SchoolYear::orderBy('id', 'DESC')->get()->take(10);

        return response()->json($schoolYear);
    }
}
