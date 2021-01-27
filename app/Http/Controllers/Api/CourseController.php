<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Course\ListCourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Validator;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'courses.name');
        $orderDirection = $request->query('sort_order', 'desc');

        $courses = Course::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('code', 'LIKE', '%' . $search . '%');

        $courses = $courses->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListCourseResource::collection($courses);
    }

    public function show($id)
    {
        $student = Course::find($id);

        return response()->json($student);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $course = new Course();
        $course->code = $request->code;
        $course->name = $request->name;
        $course->save();

        return response()->json($course);
    }

    public function update($id, Request $request)
    {
        $course = Course::find($id);

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $course->code = $request->code;
        $course->name = $request->name;
        $course->save();

        return response()->json($course);
    }

    public function delete($id)
    {
        $course = Course::find($id);
        $course->delete();

        return response()->json($course);
    }
}
