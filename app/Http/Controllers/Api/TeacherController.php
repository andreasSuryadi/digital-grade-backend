<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\ListTeacherResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'users.first_name');
        $orderDirection = $request->query('sort_order', 'desc');

        $teachers = User::where(function ($x) use ($search) {
            $x->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
        })
            ->where('role', 'teacher');

        $teachers = $teachers->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListTeacherResource::collection($teachers);
    }

    public function show($id)
    {
        $teacher = User::find($id);

        return response()->json($teacher);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nig' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
            'password' => 'required|string|max:255',
            'address' => 'required|string',
            'blood_type' => 'required|string',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'profile_picture_url' => 'sometimes|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $teacher = new User();
        $teacher->nig = $request->nig;
        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->phone_number = $request->phone_number;
        $teacher->place_of_birth = $request->place_of_birth;
        $teacher->date_of_birth = $request->date_of_birth;
        $teacher->gender = $request->gender;
        $teacher->address = $request->address;
        $teacher->blood_type = $request->blood_type;
        $teacher->role = 'teacher';
        $teacher->email = $request->email;
        $teacher->password = Hash::make($request->password);
        $teacher->save();

        return response()->json($teacher);
    }

    public function update($id, Request $request)
    {
        $teacher = User::find($id);

        $validator = Validator::make($request->all(), [
            'nig' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
            'address' => 'required|string',
            'blood_type' => 'required|string',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'gender' => 'required',
            'profile_picture_url' => 'sometimes|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }

        $teacher->nig = $request->nig;
        $teacher->first_name = $request->first_name;
        $teacher->last_name = $request->last_name;
        $teacher->phone_number = $request->phone_number;
        $teacher->place_of_birth = $request->place_of_birth;
        $teacher->date_of_birth = $request->date_of_birth;
        $teacher->gender = $request->gender;
        $teacher->address = $request->address;
        $teacher->blood_type = $request->blood_type;
        $teacher->role = 'teacher';
        $teacher->email = $request->email;
        $teacher->save();

        return response()->json($teacher);
    }

    public function delete($id)
    {
        $teacher = User::find($id);
        $teacher->delete();

        return response()->json($teacher);
    }
}
