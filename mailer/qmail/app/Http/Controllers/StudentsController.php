<?php

namespace App\Http\Controllers;

use App\Students;
use Illuminate\Http\Request;
use DB;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //list all students
        $data = Students::all();
        // foreach ($data as $s){
        //   echo $s->name;
        // }
        return view('Students.index',compact('data'))
            ->with('i', 0);
    }

    public function active(Request $request)
    {
        //list all students
        $data = Students::where('status', 'active')->get();
        // foreach ($data as $s){
        //   echo $s->name;
        // }
        return view('Students.index',compact('data'))
            ->with('i', 0);
    }




    public function waiting(Request $request)
    {
        //list all students
        $data = Students::where('status', 'waiting')->get();
        // foreach ($data as $s){
        //   echo $s->name;
        // }
        return view('Students.index',compact('data'))
            ->with('i', 0);
    }

    public function done(Request $request)
    {
        //list all students
        $data = Students::where('status', 'done')->get();
        // foreach ($data as $s){
        //   echo $s->name;
        // }
        return view('Students.index',compact('data'))
            ->with('i', 0);
    }
    public function inclass($cid)
    {
        //list all students
        $data = Students::where('status', 'active')->get();
        // foreach ($data as $s){
        //   echo $s->name;
        // }
        return view('Students.index',compact('data'))
            ->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit(Students $students)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Students $students)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Students $students)
    {
        //
    }
}
