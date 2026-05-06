<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\AdminModel;
use Illuminate\Pagination\Paginator;

class AdminController extends Controller
{

public function index()
{
    try {
        Paginator::useBootstrap();
        $List = AdminModel::orderBy('id', 'desc')->paginate(5); //order by & pagination
        return view('admin.list', compact('List'));
    } catch (\Exception $e) {
       Log::error('Admin list error: '.$e->getMessage());
         return view('errors.404');
    }
}

    public function adding() {
        return view('admin.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'admin_username.required' => 'กรุณากรอกข้อมูล',
            'admin_username.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'admin_username.unique' => 'User name ซ้ำ เพิ่มใหม่อีกครั้ง',
            'admin_username.email' => 'รูปแบบ email ไม่ถูกต้อง',

            'admin_password.required' => 'กรุณากรอกข้อมูล',
            'admin_password.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',

            'admin_name.required' => 'กรุณากรอกข้อมูล',
            'admin_name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
        ];

        //rule 
        $validator = Validator::make($request->all(), [
            'admin_username' => 'required|email|min:3|unique:tbl_admin', //unique: ใส่ชื่อตารางด้วย ไม่ให้ใส่ข้อมูลซ้ำ
            'admin_password' => 'required|min:3',
            'admin_name' => 'required|min:3',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('admin/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            AdminModel::create([
                'admin_name' => strip_tags($request->input('admin_name')), //ป้องกันการกรอก script ด้วย
                'admin_username' => strip_tags($request->input('admin_username')), //ป้องกันการกรอก script ด้วย
                'admin_password' => bcrypt($request->input('admin_password')),
                ]);  
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/admin'); //กลับไปที่หน้า index
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun create



 public function edit($id)
    {
        try {
            //query data for form edit 
            $test = TestModel::findOrFail($id); // ใช้ findOrFail เพื่อให้เจอหรือ 404
            if (isset($test)) {
                $id = $test->id;
                $name = $test->name;
                $name2 = $test->name2;
                return view('test.edit', compact('id', 'name', 'name2'));
            }
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //func edit


 public function update($id, Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'name.required' => 'กรุณากรอกข้อมูล',
            'name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'name.unique' => 'ชื่อนี้ถูกใช้งานแล้ว',  //ป้องกันแก้ซ้ำกับ row อื่นๆ จ้าาา

            'name2.required' => 'กรุณากรอกข้อมูล',
            'name2.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
        ];

        //rule
        $validator = Validator::make($request->all(), [
            'name' => [
                    'required',
                    'min:3',
                        Rule::unique('tbl_test', 'name')->ignore($id, 'id'), //ห้ามแก้ซ้ำ
            ],

            'name2' => 'required|min:3',
    ], $messages);

    //check 
        if ($validator->fails()) {
            return redirect('test/' . $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $test = TestModel::find($id);
            $test->update([
                    'name' => strip_tags($request->input('name')), //column update 
                    'name2' => strip_tags($request->input('name2')), //column update 
                ]);
            // แสดง Alert ก่อน return
            Alert::success('ปรับปรุงข้อมูลสำเร็จ');
            return redirect('/test');
        } catch (\Exception $e) {
            //return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            return view('errors.404');
        }
    } //fun update 


    public function remove($id)
    {
        echo '<pre>';
        dd($_POST);
        exit();
                try {
            $test = TestModel::find($id);  //query หาว่ามีไอดีนี้อยู่จริงไหม 
            $test->delete();
            Alert::success('Delete Successfully');
            return redirect('/test');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); //สำหรับ debug
            //return view('errors.404');
        }
    } //remove 


} //class
