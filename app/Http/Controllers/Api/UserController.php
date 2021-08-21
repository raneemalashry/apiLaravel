<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ResponseTrait;


    public function index(Request $request){
      $index= User::where(function ($query) use ($request) {
        $query->where('id',  $request->id);

    })->get();
    $index->load('categories');
    return $this->jsonResponse('sucess','done',$index) ;

    }
    public function register(Request $request){
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
    $user= User:: create($request->all());
  
    $categories = Category::find([$request->categories]);
    $user->categories()->attach($categories);

         return $this->jsonResponse('sucess','user registered', $user) ;
  
      }
     
    }
    public function login(Request $request){
        $rules = [
            'email'=>'email',
            'password'=>'min:6'


        ];


        $data = validator()->make($request->all(), $rules);

        if ($data->fails()) {
            return $this->jsonResponse('fail','error',$data->errors());
        } else {
            if (Auth::attempt(array('email' => $request->email, 'password' => $request->password))){
                $user = $request->user();
                $sucess['token']=$user->createToken('myApp')->accessToken;
                $sucess['name']=$user->name;
                $msg= "you logged in";
            }else{
                $msg= "email or password is wrong";
                $sucess=null;
            }
     
        
         return $this->jsonResponse('sucess',$msg, $sucess) ;
  
      }
     
    }
    public function update(Request $request){
        $rules = [
            'name'=>'sometimes|string',
            'email'=>'sometimes|email|unique:users,email',
            'password'=>'sometimes|nullable|min:6' ,
        'category'=>'sometimes|integer' 
    ];


        $data = validator()->make($request->all(), $rules);

        if ($data->fails()) {
            return $this->jsonResponse('fail','error',$data->errors());
        } else {
            if($request->password){
                $request->merge(['password'=> bcrypt($request->password)]);
            }
       
        $record = User::findorfail($request->id);
        $record->categories()->sync($request->category);

        $update= $record-> update($request->all());

      return $this->jsonResponse('sucess','done',$record) ;
  
      }
     


    }
    public function destroy(request $request)  
    {
        
        $record = User::findorfail($request->id);
        $record->categories()->detach();
        $record->delete();

        return $this->jsonResponse('sucess','deleted') ;
    }



}
