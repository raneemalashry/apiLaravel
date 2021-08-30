<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    use ResponseTrait;


    public function index(Request $request){
    //   $index= User::where(function ($query) use ($request) {
    //     $query->where('id',  $request->id);

    // })->get();
    // $index->load('categories');
    $index = user::all()->random(5);
    return $this->jsonResponse('sucess','done',$index) ;

    }
    public function create()
    {
        return view('create');
    }
    public function store(Request $request){
        $rules = [
            'name'=>'required|string',
            'email'=>'email|unique:users,email',
            'password'=>'min:6'


        ];


        $data = validator()->make($request->all(), $rules);

        if ($data->fails()) {
           return $this->jsonResponse(0,'error',$data->errors());
        } else {
            
     $request->merge(['password'=> bcrypt($request->password)]);

    $user= User:: create($request->all());
                if ($request->categories) {
                    foreach($request->categories as $category){
               
                        $user->categories()->attach($category);
                    }
                }
        

         return $this->jsonResponse(1,'user registered' ,$user) ;
        // return response()->json(['success'=>'Data is successfully added',$user]);
  
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
     
        
         return $this->jsonResponse('success',$msg, $sucess) ;
  
      }
     
    }
    public function update(Request $request){
        $rules = [
            'name'=>['sometimes','string',
            function ($attribute, $value, $fail) {
                if ($value === "ahmed") {
                    $fail("The".$attribute." is invalid.");
                }
            }],
            'email'=>'sometimes|email',
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
          $record->update($request->all());
        //$record->created_at=Carbon::now();
    
      // $duplicate = $record->replicate()->fill($request->all());
    //    $duplicate->email='raneem@r.com';
       //$duplicate->touch();
     // $duplicate->save();
    // $record=User::firstOrCreate(['email'=>$request->email,'name'=>$request->name, 'password'=> $request->password]);

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
