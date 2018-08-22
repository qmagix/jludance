<?php

namespace App\Http\Controllers;

use App\Klass;
use Illuminate\Http\Request;
use App\Students;
use DB;
use Mail;

class KlassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Klass::all();
        // foreach ($data as $s){
        //   echo $s->name;
        // }
        return view('Klass.index',compact('data'))
            ->with('i', 0);
    }
    public function active(Request $request)
    {
        //list all students
        $data = Klass::where('visible', 1)->get();
        // foreach ($data as $s){
        //   echo $s->name;
        // }
        return view('Klass.index',compact('data'))
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
     * @param  \App\Klass  $klass
     * @return \Illuminate\Http\Response
     */
    public function show(Klass $klass)
    {
        //
        $a=$this->studentsids($klass->id);
        //dd($a);
        //$data=DB::select('select * from users where id IN ('.implode(',',$a).')');
        $data = Students::whereIn('id', $a)->orderBy('id','DESC')->get();
        return view('Klass.show',compact('data', 'klass'))->with('i',0);
    }

    public function email(Request $request, Klass $klass){
        $a=$this->studentsids($request->input('classid'));
        $subjecttmp=$request->input('subject');
        $messagetmp=$request->input('message');
        $data = Students::whereIn('id', $a)->orderBy('id','DESC')->get();
        $i=1;
        foreach ($data as $key => $user){
          $subject=str_replace("{{name}}", $user->name,$subjecttmp);
          $message=str_replace("{{name}}", $user->name,$messagetmp);
          Mail::send([], ['message'=>$message, 'subject'=>$subject, 'user'=>$user], function ($m) use ($user,$message,$subject) {
            $m->from('info@jludance.com', 'JLUdance');

            //$m->to($user->email, $user->name)->subject($subject);
            $m->to('qingfenghuang@msn.com', $user->name)
              ->subject($subject)
              ->setBody($message);
          });
          echo "<hr>Message sent ".$i." to ".$user->email.": ".$subject."--".$message;
          $i++;
        }
        //return view('Klass.show',compact('data', 'klass'))->with('i',0);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Klass  $klass
     * @return \Illuminate\Http\Response
     */
    public function edit(Klass $klass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Klass  $klass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Klass $klass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Klass  $klass
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klass $klass)
    {
        //
    }



    private function studentsids($classid){
      $result = DB::select('select sid from participation where cid = ?', [$classid]);
      $a=array();
      foreach ($result as $row){
        $a[]=$row->sid;
      }

      return $a;
    }

    public function students($classid){
      $a=$this->studentsids($classid);
      //dd($a);
      //$data=DB::select('select * from users where id IN ('.implode(',',$a).')');
      $data = Students::whereIn('id', $a)->orderBy('id','DESC')->get();
      return view('students.index',compact('data'))->with('i',0);

    }
}
