<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Employee;
class EmployeeController extends Controller
{
    public function index(){

        return view("index");
    }
    
    public function fetch_employee(){

        $employee = Employee::all();

        return response()->json([

            'employee' => $employee,
        ]);
    }

    public function store(Request $request){

        $validator = \Validator::make($request -> all(),[

            'name' => 'required',
            'phone' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
 
        ]);

        if($validator -> fails()){

            return response()->json([

                // 'status' => 400,
                // 'errors' => $validator->message()
                'code' => 0, 
                'error' => $validator->errors()->toArray()
            ]);
        }
        else{

            $employee = new Employee;

            $employee -> name = $request -> name;
            $employee -> phone = $request -> phone;

            if($request ->hasfile('image')){

                $file = $request->file('image');
                $extension = $file -> getClientOriginalExtension();
                $filename = time() . '.' .$extension;
                $file -> move('upload/employee/', $filename);

                $employee -> image = $filename;
            }
            $employee -> save();

            return response()->json([

                'code' => 1, 'msg' => 'success'
            ]);
        }
    }

    public function edit_employee($id){

         $employee = Employee::find($id);

         if($employee){

            return response()->json([

                'status' => 200, 
                'employee' => $employee,
            ]);
         }
         else{

             return response()->json([

                'status' => 404, 
                'msg' => 'Employee Not Found',
            ]);
         }
    }

    public function update(Request $request, $id ){

        $validator = \Validator::make($request -> all(),[

            'name' => 'required',
            'phone' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
 
        ]);

        if($validator -> fails()){

            return response()->json([

                // 'status' => 400,
                // 'errors' => $validator->message()
                'status' => 400, 
                'error' => $validator->errors()->toArray()
            ]);
        }
        else{

            $employee =  Employee::find($id);
            if($employee){

                $employee -> name = $request -> name;
                $employee -> phone = $request -> phone;

                if($request ->hasfile('image')){

                    $path = 'upload/employee'.$employee -> image;

                    if(File::exists($path))
                    {
                        File::delete($path);
                    }

                    $file = $request->file('image');
                    $extension = $file -> getClientOriginalExtension();
                    $filename = time() . '.' .$extension;
                    $file -> move('upload/employee/', $filename);

                    $employee -> image = $filename;
                }
                $employee -> save();

                return response()->json([

                    'status' => 200,
                     'msg' => 'Employee Update Successfully'
                ]);

            }
            else{

                 return response()->json([

                    'status' => 404,
                     'msg' => 'Employee Not Found'
                ]);
            }
        }
    }

   
}
