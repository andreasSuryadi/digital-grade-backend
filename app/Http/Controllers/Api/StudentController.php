<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\ListStudentResource;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->query('per_page', 10);
        $orderBy = $request->query('sort_field', 'users.first_name');
        $orderDirection = $request->query('sort_order', 'desc');

        $Students = User::where(function ($x) use ($search) {
            $x->where('first_name', 'LIKE', '%' . $search . '%')
                ->orWhere('last_name', 'LIKE', '%' . $search . '%');
        })
            ->where('role', 'student');

        $Students = $Students->orderBy($orderBy, $orderDirection)->paginate($perPage);

        return ListStudentResource::collection($Students);
    }
}
