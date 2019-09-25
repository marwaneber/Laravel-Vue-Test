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
    public function __construct(){
        $this->middleware('auth');
    }

    public function showHomePage(){
        return view('home');
    }

    public function showUpdatePassword(){
        return view('auth/update_password');
    }

    public function adminCredentialRules(array $data){
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

    public function getAllItems(){
        // Send data by pagination of '3 per Page' and ordered by the date of create
        $items_data = Items::orderBy('created_at', 'desc')->paginate(3);
        return $items_data;
    }

    public function postCredentials(Request $request){
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

    public function addNewItem(Request $request){
        // Extract the base64 of the image
        $exploded = explode(',', $request->image);

        // Decoding the image
        $image_decoded = base64_decode($exploded[1]);

        // Extract the extension of the image
        $image_extension = explode(';', str_replace("data:image/", "", $exploded[0]))[0];

        // Generate randomly a name of the image
        $image_file_name = str_random(10).'.'.$image_extension;

        // Create a path for the image
        $image_path = public_path() . "/uploads/" . $image_file_name;

        // Write the coded image
        file_put_contents($image_path, $image_decoded);

        // Store the item into the DB
        $item = new Items();
        $item->title = $request->title;
        $item->description = $request->description;
        $item->image = "/uploads/" . $image_file_name;
        $item->save();

        // Return JSON response of success
        return response()->json([
            'user' => $item,
            'message' => 'Success'
          ], 200);
    }
}
