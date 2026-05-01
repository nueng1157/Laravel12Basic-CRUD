<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TestModel;
use Illuminate\Pagination\Paginator;

class TestController extends Controller
{

public function index()
{
    try {
        Paginator::useBootstrap();
        $testList = TestModel::orderBy('id', 'desc')->paginate(5); //order by & pagination
        return view('test.list', compact('testList'));
    } catch (\Exception $e) {
       // \Log::error('Admin list error: '.$e->getMessage());
         return view('errors.404');
    }
}

    public function adding() {
        return view('test.create');
    }

    public function create(Request $request)
    {
        // echo '<pre>';
        // dd($_POST);
        // exit();

        //vali msg 
        $messages = [
            'name.required' => 'กรุณากรอกข้อมูล',
            'name.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
            'name.unique' => 'ชื่อซ้ำ เพิ่มใหม่อีกครั้ง',

            'name2.required' => 'กรุณากรอกข้อมูล',
            'name2.min' => 'กรอกข้อมูลขั้นต่ำ :min ตัวอักษร',
        ];

        //rule 
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:tbl_test', //unique: ใส่ชื่อตารางด้วย ไม่ให้ใส่ข้อมูลซ้ำ
            'name2' => 'required|min:3',
        ], $messages);

        //check vali 
        if ($validator->fails()) {
            return redirect('test/adding')
                ->withErrors($validator)
                ->withInput();
        }

        try {

            //ปลอดภัย: กัน XSS ที่มาจาก <script>, <img onerror=...> ได้
            TestModel::create([
                'name' => strip_tags($request->input('name')), //ป้องกันการกรอก script ด้วย
                'name2' => strip_tags($request->input('name2')), //ป้องกันการกรอก script ด้วย
            ]);
            // แสดง Alert ก่อน return
            Alert::success('เพิ่มข้อมูลสำเร็จ');
            return redirect('/test'); //กลับไปที่หน้า index
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
