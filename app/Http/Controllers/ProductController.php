<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //แสดงหน้าหลัก
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //เรียกฟอร์มเพิ่มข้อมูล
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //รับค่าจากฟอร์มเพิ่มข้อมูลเอาไปเก็บในตาราง
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //หน้าฟอร์มแก้ไข แสดงข้อมูล single row
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //หน้าฟอร์มแก้ไข แสดงข้อมูล function show
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //รับค่าจากฟอร์มแก้ไข เพื่อแก้ไขข้อมูลในตาราง
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //รับค่าจากฟอร์มเพื่อลบข้อมูล
    }
}
