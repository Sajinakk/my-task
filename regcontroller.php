<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class regcontroller extends Controller
{
    function Insertdata(Request $req){
        $name = $req->name;
        $email = $req->email;
        $mob = $req->mob;
        $pass = $req->pass;
        $res = DB::table('data')->insert(['name'=>$name,'email'=>$email,'mob'=>$mob,'password'=>$pass]);
        if($res){
            return response()->json(array('message'=>'insert successfully'));
        }
        else{
            return response()->json(array('message'=>'faild'));
        }
    }
    function Getdata(){
        $users=DB::table('data')->get();
        return response()->json(array('data'=>$users));
    }
    function Deletedata(Request $req){
        $id=$req['id'];
        DB::table('data')->where('id',$id)->delete();
        return response()->json(array('message'=>'Record successfully deleted'));
    }
    function fetchdata($id){
        $id=DB::table('data')->find($id);
        return response()->json(array('data'=>$id));
    }
    function Updatedata(Request $req){
        $id = $req->id;
        $name = $req->name;
        $email = $req->email;
        $mob = $req->mob;
        $pass = $req->pass;
        $res = DB::table('data')->where('id',$id)->update(['name'=>$name,'email'=>$email,'mob'=>$mob,'password'=>$pass]);
        return response()->json(array('message'=>'Record successfully updated'));
    }

    function Usersubmit(Request $request){

        $this->validate(
            $request,
            [
                'name'=>'required',
                'date'=>'required',
                'amount'=>'required|regex:/^\d+(\.\d{1,2})?$/',
                'description'=>'required',

            ],
            [
                'name.required'=>'please select Name',
                'date.required'=>'please enter date',
                'amount.required'=>'please enter amount',
                'amount.regex'=>'please enter a valid amount',
                'description.required'=>'please fill',
            ]
            );


        //$userid = $request->name;
        $date = $request->date;
        $amount = $request->amount;
        $description = $request->description;
        $name = $request->name;
        $id=DB::table('data')->select('id')->where('name',$name)->first();
        //dd($id->id);
        $res = DB::table('userdata')->insert(['user_id'=>$id->id,'date'=>$date,'amount'=>$amount,'description'=>$description]);
        if($res){
            return response()->json(array('message'=>'insert successfully'));
        }
        else{
            return response()->json(array('message'=>'failed'));
        }
    }
    function usergetdata(){
        $users=DB::table('userdata')->get();
        return response()->json(array('data'=>$users));
    }
    function userdeletedata(Request $req){
        $id=$req['id'];
        DB::table('userdata')->where('id',$id)->delete();
        return response()->json(array('message'=>'Record successfully deleted'));
    }
    function userfetchdata($id){
        $id=DB::table('userdata')->find($id);
        return response()->json(array('data'=>$id));
    }
    function userupdatedata(Request $req){
        $id = $req->id;
        $userid=$req->userid;
        $date = $req->date;
        $amount = $req->amount;
        $description = $req->description;
        $res = DB::table('userdata')->where('id',$id)->update(['date'=>$date,'amount'=>$amount,'description'=>$description]);
        return response()->json(array('message'=>'Record successfully updated'));
    }
    function fetchname(){

        $data=DB::table('data')->get();
        //dd($data);
        return view('userdata',compact('data'));
    }
}
