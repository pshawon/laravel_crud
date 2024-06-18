<?php

namespace App\Http\Controllers;
use App\Models\Profiles;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class ProfilesController extends Controller
{
    public function index(){   //show profile data
       
        $profiles= Profiles::orderBy('created_at', 'desc')->get();
       
        return view('profiles.list',[
            'profiles'=>$profiles
        ]);


    }
    public function create(){   //create profile data

        return view ('profiles.create');
        
    }
    public function store(Request $request){   //store profile data
        $rules=[
            
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|regex:/(01)[0-9]{9}/',
            'address'=>'required',
            'attached' => 'mimes:pdf|max:5048',
        ];

        if($request->image != ""){

            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:5048';


        }



        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('profiles.create')->withInput()->withErrors($validator);

        } 
        $profile= new Profiles();
        $profile->name=$request->name;
        $profile->email=$request->email;
        $profile->phone=$request->phone;
        $profile->address=$request->address;
        $profile->image=$request->image;
        $profile->save();


        //Storing image
        if($request->image != ""){
                $image= $request->image;
                $ext= $image->getClientOriginalExtension();
                $image_name= time().'.'.$ext;
                $image->move(public_path('/uploads/profiles'), $image_name);
                $profile->image= $image_name;
                $profile->save();
        }

        //Storing attached
        if($request->attached != ""){
            $attached= $request->attached;
            $ext= $attached->getClientOriginalExtension();
            $attached_name= time().'.'.$ext;
            $attached->move(public_path('/uploads/attached'), $attached_name);
            $profile->attached= $attached_name;
            $profile->save();
        }


        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');

    }


    //View edit file data
    public function view_file($id){
        $profile= Profiles::findOrfail($id);
        return view('profiles.pdf_viewer', ['profile' => $profile]);

    }
    public function edit($id){  //edit profile data
        $profile= Profiles::findOrfail($id);
        return view ('profiles.edit',[
            'profile'=>$profile]);

    }
    public function update($id, Request $request){   //update profile data
        $profile= Profiles::findOrfail($id);
        $rules=[
            
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|regex:/(01)[0-9]{9}/',
            'address'=>'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'attached' => 'mimes:pdf|max:5048',
        ];


        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return redirect()->route('profiles.edit',$profile->id)->withInput()->withErrors($validator);

        } 
        $profile->name=$request->name;
        $profile->email=$request->email;
        $profile->phone=$request->phone;
        $profile->address=$request->address;
        $profile->image=$request->image;
        $profile->save();


        
        if($request->image != ""){
            //delet Old Image
                File::delete(public_path('/uploads/profiles/'.$profile->image));
             
             //Storing New Image   
                $image= $request->image;
                $ext= $image->getClientOriginalExtension();
                $image_name= time().'.'.$ext;
                $image->move(public_path('/uploads/profiles'), $image_name);
                $profile->image= $image_name;
                $profile->save();
        }


        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');


        
    }
    public function destroy($id){ 
        
        $profile= Profiles::findOrFail($id);
       
        //Delet Image       
            File::delete( public_path('/uploads/profiles/'.$profile->image) );

        //Delet attachmented
            File::delete( public_path('/uploads/attached/'.$profile->attached) );
       
         //Delet profile data
         $profile->delete();     
        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
        
    }


    
}
