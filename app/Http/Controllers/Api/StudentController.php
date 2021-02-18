<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ListStudentResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'users.first_name');
        $orderDirection = $request->query('sort_order', 'desc');

        $students = User::where(function ($x) use ($search) {
            $x->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
        })
            ->where('role', 'student');

        $students = $students->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListStudentResource::collection($students);
    }

    public function show($id)
    {
        $student = User::with(['class'])->find($id);

        return response()->json($student);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => 'required|string',
            'nisn' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'class' => 'required',
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

        $student = new User();
        $student->class_id = $request->class[0]['id'];
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->phone_number = $request->phone_number;
        $student->place_of_birth = $request->place_of_birth;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->blood_type = $request->blood_type;
        $student->role = 'student';
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->save();

        return response()->json($student);
    }

    public function update($id, Request $request)
    {
        $student = User::find($id);

        $validator = Validator::make($request->all(), [
            'nis' => 'required|string',
            'nisn' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'class' => 'required',
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

        $student->class_id = $request->class[0]['id'];
        $student->nis = $request->nis;
        $student->nisn = $request->nisn;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->phone_number = $request->phone_number;
        $student->place_of_birth = $request->place_of_birth;
        $student->date_of_birth = $request->date_of_birth;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->blood_type = $request->blood_type;
        $student->role = 'student';
        $student->email = $request->email;
        $student->save();

        return response()->json($student);
    }

    public function delete($id)
    {
        $student = User::find($id);
        $student->delete();

        return response()->json($student);
    }

    public function searchStudentByName(Request $request)
    {
        $search = $request->search;

        $students = User::where(function ($x) use ($search) {
                $x->where('first_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%');
            })
            ->where('role', 'student')
            ->get();

        return response()->json($students);
    }
}
