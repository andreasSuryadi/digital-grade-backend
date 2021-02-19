<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassesStudent;
use App\Models\ClassesUser;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class GradeController extends Controller
{
    public function getGradeBySchedule(Request $request, $scheduleId)
    {
        $search = $request->search;

        $grades = Grade::whereScheduleId($scheduleId)->get();

        $schedule = Schedule::find($scheduleId);

        $classes = Classes::with(['user'])
            ->whereId($schedule->class_id)
            ->first();

        $gradeData = [];
        if (count($grades) == 0) {
            foreach ($classes->user as $user) {
                $gradeData[] = [
                    'nis' => $user->nis,
                    'class_id' => $classes->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'grade' => 0,
                ];
            }
        } else {
            foreach ($grades as $grade) {
                $classesStudent = ClassesUser::find($grade->classes_user_id);

                $student = User::find($classesStudent->user_id);
                
                $gradeData[] = [
                    'nis' => $student->nis,
                    'class_id' => $classes->id,
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'grade' => $grade->grade,
                ];
            }
        }

        return response()->json($gradeData);
    }

    public function saveGradeByClass(Request $request)
    {
        $grades = $request->grades;

        foreach ($grades as $grade) {
            $user = User::where('nis', $grade['studentNis'])->first();

            $classesStudent = ClassesUser::where('classes_id', $grade['classId'])
                ->where('user_id', $user->id)
                ->first();

            $gradeData = Grade::where('classes_user_id', $classesStudent->id)
                ->where('schedule_id', $request->id)
                ->first();

            if (is_null($gradeData)) {
                $gradeData = Grade::create([
                    'classes_user_id' => $classesStudent->id,
                    'schedule_id' => $request->id,
    
                    'grade' => $grade['grade'],
                ]);
            } else {
                $gradeData->update([
                    'grade' => $grade['grade']
                ]);
            }
        }
    }

    public function getGradeByClass(Request $request, $classId)
    {
        $semester = $request->semester == 0 ? 1 : 2;

        $schedules = Schedule::with(['schoolYear', 'course'])
            ->whereHas('schoolYear', function ($x) use ($semester) {
                $x->where('semester', $semester);
            })
            ->where('class_id', $classId)
            ->get();

        $classesUser = ClassesUser::where('classes_id', $classId)
            ->where('user_id', $request->user()->id)
            ->first();
           
        $listGrades = [];
        foreach ($schedules as $schedule) {
            $grade = Grade::where('schedule_id', $schedule->id)
                ->where('classes_user_id', $classesUser->id)
                ->first();

            if (!is_null($grade)) {
                $listGrades[] = [
                    'course' => $schedule->course->name,
                    'grade' => $grade->grade,
                    'status' => 'Sudah Diisi',
                ];
            } else {
                $listGrades[] = [
                    'course' => $schedule->course->name,
                    'grade' => 0,
                    'status' => 'Belum Diisi',
                ];
            }
        }

        return response()->json($listGrades);
    }

    public function printRaport(Request $request, $classId)
    {
        $semester = $request->semester == 0 ? 1 : 2;

        $student = User::find($request->user()->id);
        $class = Classes::find($classId);

        $schedules = Schedule::with(['schoolYear', 'course'])
            ->whereHas('schoolYear', function ($x) use ($semester) {
                $x->where('semester', $semester);
            })
            ->where('class_id', $classId)
            ->get();

        $classesUser = ClassesUser::where('classes_id', $classId)
            ->where('user_id', $request->user()->id)
            ->first();
           
        $listGrades = [];
        $startYear = 0;
        $endYear = 0;
        foreach ($schedules as $schedule) {
            $grade = Grade::where('schedule_id', $schedule->id)
                ->where('classes_user_id', $classesUser->id)
                ->first();

            $startYear = $schedule->schoolYear->start_year;
            $endYear = $schedule->schoolYear->end_year;

            if (!is_null($grade)) {
                $listGrades[] = [
                    'course' => $schedule->course->name,
                    'grade' => $grade->grade,
                    'status' => 'Sudah Diisi',
                ];
            } else {
                $listGrades[] = [
                    'course' => $schedule->course->name,
                    'grade' => 0,
                    'status' => 'Belum Diisi',
                ];
            }
        }

        $pdf = PDF::loadView('raport', [
            'nis' => $student->nis,
            'nisn' => $student->nisn,
            'name' => $student->name,
            'semester' => $semester,
            'startYear' => $startYear,
            'endYear' => $endYear,
            'class' => $class->name,
            'grades' => $listGrades,
        ]);

        $pdf->setPaper('A4');

        return $pdf->download('report.pdf');
    }
}
