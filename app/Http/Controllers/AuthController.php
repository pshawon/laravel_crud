<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilesController;
use App\Models\Profiles;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);
            Profiles::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
             return redirect()->route ('login')->with('success', 'Register Successfully! Please login');

        }
        return view ( 'user.register') ;

    }

    public function login(Request $request){
        if($request-> isMethod('post')){
            $request-> validate([
                "email" => "required|email",
                "password" => "required"
            ]);
            if(Auth::guard('profiles')->attempt([
                "email" => $request->email,
                "password" => $request->password
            ])){
                $user = Auth::guard('profiles')->user();
                return redirect()->route("user.dashboard",['id' => $user->id]);

            } else{
            return redirect()->route('login')->with("error","Invalid Credentials");
                }
        }
        return view('user.login');
    }

    public function dashboard($id){
        $user = Profiles::findOrfail($id);
        return view('user.dashboard',compact('user'));
    }

    public function user_view($id){
        $user=Profiles::findOrfail($id);
        return view('user.userinfo',compact('user'));
    }

    public function user_edit($id){
        $user=Profiles::findOrfail($id);
        return view('user.useredit',compact('user'));
    }

    // public function user_update($id, Request $request){   //update User data
    //     $user= Profiles::findOrfail($id);
    //     $rules=[

    //         'name'=>'required',
    //         'email'=>'required|email',
    //         'phone'=>'required|regex:/(01)[0-9]{9}/',
    //         'address'=>'required',
    //     ];

    //     $rules ['image']='image|mimes:jpeg,png,jpg,gif,svg|max:5048';
    //     $rules ['attached']='mimes:pdf|max:5048';

    //     if ($user->image ="") {
    //         $rulse['image']= 'required|'.$rulse['image'];

    //     }
    //     if ($user->attached ="") {
    //         $rulse['attached']= 'required|'.$rulse['attached'];

    //     }





    //     $validator = Validator::make($request->all(), $rules);
    //     if($validator->fails()){
    //         return redirect()->route('user.edit',$user->id)->withInput()->withErrors($validator);

    //     }
    //     $user->name=$request->name;
    //     $user->email=$request->email;
    //     $user->phone=$request->phone;
    //     $user->address=$request->address;
    //     $user->image=$request->image;
    //     $user -> attached = $request -> attached;




    //     if($request->image != ""){
    //         //delet Old Image
    //             File::delete(public_path('/uploads/profiles/'.$user->image));

    //          //Storing New Image
    //             $image= $request->image;
    //             $ext= $image->getClientOriginalExtension();
    //             $image_name= time().'.'.$ext;
    //             $image->move(public_path('/uploads/profiles'), $image_name);
    //             $user->image= $image_name;

    //     }
    //     //For attachment
    //     if($request->attached != ""){
    //         //delet Old Image
    //             File::delete(public_path('/uploads/attached/'.$user->attached));

    //          //Storing New Image
    //             $attached= $request->attached;
    //             $ext= $attached->getClientOriginalExtension();
    //             $attached_name= time().'.'.$ext;
    //             $attached->move(public_path('/uploads/attached'), $attached_name);
    //             $user->attached= $attached_name;

    //     }
    //     $user->save();

    //     return redirect()->route('user.edit',$user->id)->with('success', 'User Profile updated successfully.');

    // }

    public function user_update($id, Request $request)
    {
        // Find the user or fail
        $user = Profiles::findOrFail($id);

        // Define validation rules
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^01\d{9}$/',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'attached' => 'mimes:pdf|max:5048'
        ];

        // Add 'required' to image and attached if they are empty
        if (empty($user->image)) {
            $rules['image'] = 'required|' . $rules['image'];
        }
        if (empty($user->attached)) {
            $rules['attached'] = 'required|' . $rules['attached'];
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('user.edit', $user->id)
                ->withInput()
                ->withErrors($validator);
        }

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image) {
                File::delete(public_path('/uploads/profiles/' . $user->image));
            }

            // Store new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/profiles/'), $imageName);
            $user->image = $imageName;
        }

        // Handle attachment upload
        if ($request->hasFile('attached')) {
            // Delete old attachment if exists
            if ($user->attached) {
                File::delete(public_path('/uploads/attached/' . $user->attached));
            }

            // Store new attachment
            $attached = $request->file('attached');
            $attachedName = time() . '.' . $attached->getClientOriginalExtension();
            $attached->move(public_path('/uploads/attached/'), $attachedName);
            $user->attached = $attachedName;
        }

        // Save updated user profile
        $user->save();

        // Redirect with success message
        return redirect()->route('user.edit', $user->id)
            ->with('success', 'User Profile updated successfully.');
    }




    public function logout(){
        Session::flush();
        Auth::logout();
        return to_route('login')-> with('success',"Log out successfully!");

    }
}
