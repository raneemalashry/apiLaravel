<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;


class UserController extends Controller
{
    use ResponseTrait;


    public function index(Request $request){
      $index= User::where(function ($query) use ($request) {
        $query->where('id',  $request->id);

    })->get();
    return $this->jsonResponse('sucess','done',$index) ;

    }
    public function create(Request $request){
        $rules = [
            'name'=>'required|string',
            'email'=>'email|unique:users,email',
            'password'=>'min:6'


        ];


        $data = validator()->make($request->all(), $rules);

        if ($data->fails()) {
            return $this->jsonResponse('fail','error',$data->errors());
        } else {

        $request->merge(['password'=> bcrypt($request->password)]);
        $create= User:: create($request->all());

      return $this->jsonResponse('sucess','done',$create) ;
  
      }
     
    }
    public function update(Request $request){
        $rules = [
            'name'=>'required|string',
            'email'=>'email|unique:users,email',
            'password'=>'min:6' ];


        $data = validator()->make($request->all(), $rules);

        if ($data->fails()) {
            return $this->jsonResponse('fail','error',$data->errors());
        } else {

        $request->merge(['password'=> bcrypt($request->password)]);
        $record = User::findorfail($request->id);
        $update= $record-> update($request->all());

      return $this->jsonResponse('sucess','done',$update) ;
  
      }
     


    }
    public function destroy(request $request)  
    {
        
        $record = User::findorfail($request->id);
        $record->delete();
        return $this->jsonResponse('sucess','deleted') ;
    }



}
