<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Hash;
use App\User;
use App\Items;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function update_password()
    {
        return view('auth/update_password');
    }

    public function admin_credential_rules(array $data)
    {
        $messages = [
            'current-password.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
        ];

        $validator = Validator::make($data, [
            'current-password' => 'required',
            'password' => 'required|same:password',
            'password_confirmation' => 'required|same:password',     
        ], $messages);

        return $validator;
    }

    public function api(){
        $items_data = Items::all();
        return $items_data;
    }

    public function postCredentials(Request $request)
    {
        if(Auth::Check()){
            $request_data = $request->All();
            $validator = $this->admin_credential_rules($request_data);
            if($validator->fails()){
                return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
            }
            else {  
                $current_password = Auth::User()->password;           
                if(Hash::check($request_data['current-password'], $current_password)) {           
                    $user_id = Auth::User()->id;                       
                    $obj_user = User::find($user_id);
                    $obj_user->password = Hash::make($request_data['password']);;
                    $obj_user->save(); 
                    return redirect()->to('/');
                }
                else {           
                    $error = array('current-password' => 'Please enter correct current password');
                    return response()->json(array('error' => $error), 400);   
                }
            }        
        }
        else {
            return redirect()->to('/');
        }    
    }


    public function Store(Request $request){
        // Items::create($request->all());
      
            $new_item = Items::create($request->all());
       

        // return ["state" => "success"];
        // return $new_item;
    }
}
