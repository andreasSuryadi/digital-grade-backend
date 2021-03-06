<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Classes\ListClassResource;
use App\Models\Classes;
use App\Models\ClassesUser;
use Illuminate\Http\Request;
use Validator;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'courses.name');
        $orderDirection = $request->query('sort_order', 'desc');

        $classes = Classes::where('name', 'LIKE', '%' . $search . '%');

        $classes = $classes->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListClassResource::collection($classes);
    }

    public function show($id)
    {
        $class = Classes::with(['user'])
            ->find($id);

        return response()->json($class);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $class = new Classes();
        $class->name = $request->name;
        $class->save();

        foreach ($request->user as $user) {
            ClassesUser::create([
                'classes_id' => $class->id,
                'user_id' => $user['id'],
            ]);
        }

        return response()->json($class);
    }

    public function update($id, Request $request)
    {
        $class = Classes::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'user' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $class->name = $request->name;
        $class->save();

        foreach ($request->user as $user) {
            ClassesUser::create([
                'classes_id' => $class->id,
                'user_id' => $user['id'],
            ]);
        }

        return response()->json($class);
    }

    public function delete($id)
    {
        $classes = Classes::find($id);
        $classes->delete();

        return response()->json($classes);
    }

    public function searchClassByName(Request $request)
    {
        $search = $request->search;

        $classes = Classes::where('name', 'LIKE', '%' . $search . '%')->get();

        return response()->json($classes);
    }

    public function getClassByStudent(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'courses.name');
        $orderDirection = $request->query('sort_order', 'desc');

        $classes = Classes::with(['user'])
            ->whereHas('user', function ($x) use ($request) {
                $x->where('nis', $request->user()->nis);
            })
            ->where('name', 'LIKE', '%' . $search . '%');

        $classes = $classes->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListClassResource::collection($classes);
    }
}
