<?php

namespace App\Http\Controllers\Api;


use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();
        if($students->count() > 0) {

            return response()->json([
                'status' => 200,
                'students' => $students
            ], 200);
        
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'No Record Found'
            ], 404);
        
        }

    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $students = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if($students) {
                return response()->json([
                    'status' => 200,
                    'message' => "Student Created Successfuly"
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Something went wrong"
                ], 500);
            }
        }
    }
    public function show($id) {
        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Shuch Student Found!"
            ], 404);
        }
    }
    public function edit($id) {
        $student = Student::find($id);
        if($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Shuch Student Found!"
            ], 404);
        }
    }
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);
        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $student = Student::find($id);

            if($student) {
                
                $student->name = $request->input('name');
                $student->course = $request->input('course');
                $student->email = $request->input('email');
                $student->phone = $request->input('phone');
                $student->update();

                return response()->json([
                    'status' => 200,
                    'message' => "Student Updated Successfuly"
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "No Such Student Found!"
                ], 404);
            }
        }
    }
    public function destroy($id) {
        $student = Student::find($id);

        if($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Student Deleted Successfuly",
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No Such Student Found!"
            ], 404);
        }
    }
}
