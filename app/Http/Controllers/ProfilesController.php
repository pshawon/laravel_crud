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
         $profiles= Profiles::paginate(10);

        return view('profiles.list',[
            'profiles'=>$profiles
        ]);
        // return view('/profiles/', compact('profiles'));


    }
    public function create(){   //create profile data

        return view ('profiles.create');

    }
    public function store(Request $request){    //store profile data
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
    // public function update($id, Request $request){   //update profile data
    //     $profile= Profiles::findOrfail($id);
    //     $rules=[

    //         'name'=>'required',
    //         'email'=>'required|email',
    //         'phone'=>'required|regex:/(01)[0-9]{9}/',
    //         'address'=>'required',
    //         'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
    //         'attached' => 'mimes:pdf|max:5048',
    //     ];


    //     $validator = Validator::make($request->all(), $rules);
    //     if($validator->fails()){
    //         return redirect()->route('profiles.edit',$profile->id)->withInput()->withErrors($validator);

    //     }
    //     $profile->name=$request->name;
    //     $profile->email=$request->email;
    //     $profile->phone=$request->phone;
    //     $profile->address=$request->address;
    //     $profile->image=$request->image;
    //     $profile -> attached= $request -> attached;
    //     $profile->save();



    //     if($request->image != ""){
    //         //delet Old Image
    //             File::delete(public_path('/uploads/profiles/'.$profile->image));

    //          //Storing New Image
    //             $image= $request->image;
    //             $ext= $image->getClientOriginalExtension();
    //             $image_name= time().'.'.$ext;
    //             $image->move(public_path('/uploads/profiles'), $image_name);
    //             $profile->image= $image_name;
    //             $profile->save();
    //     }
    //     //Storing attached
    //     if($request->attached != ""){
    //         $attached= $request->attached;
    //         $ext= $attached->getClientOriginalExtension();
    //         $attached_name= time().'.'.$ext;
    //         $attached->move(public_path('/uploads/attached'), $attached_name);
    //         $profile->attached= $attached_name;
    //         $profile->save();
    //     }


    //     return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');



    // }

    public function update($id, Request $request)
    {
        // Find the user or fail
        $profiles = Profiles::findOrFail($id);

        // Define validation rules
        $rules = [
            'name' => 'required',
            'phone' => 'required|regex:/^01\d{9}$/',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'attached' => 'mimes:pdf|max:5048'
        ];

        // Add 'required' to image and attached if they are empty
        if (is_null($profiles->image)) {
            $rules['image'] = 'required|'. $rules['image'];
        }
        if (is_null($profiles->attached)) {
            $rules['attached'] = 'required|'. $rules['attached'];
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return redirect()->route('profiles.edit', $profiles->id)
                ->withInput()
                ->withErrors($validator);


        }



        // Update user details
        $profiles->name = $request->name;
        $profiles->phone = $request->phone;
        $profiles->address = $request->address;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($profiles->image) {
                File::delete(public_path('/uploads/profiles/' . $profiles->image));
            }

            // Store new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/profiles/'), $imageName);
            $profiles->image = $imageName;
        }

        // Handle attachment upload
        if ($request->hasFile('attached')) {
            // Delete old attachment if exists
            if ($profiles->attached) {
                File::delete(public_path('/uploads/attached/' . $profiles->attached));
            }

            // Store new attachment
            $attached = $request->file('attached');
            $attachedName = time() . '.' . $attached->getClientOriginalExtension();
            $attached->move(public_path('/uploads/attached/'), $attachedName);
            $profiles->attached = $attachedName;
        }

        // Save updated user profile
        $profiles->save();

        // Redirect with success message
        return redirect()->route('profiles.edit', $profiles->id)
            ->with('success', ' Profile updated successfully.');

    }
    public function destroy($id) {
        try {
            $profile = Profiles::findOrFail($id);

            // Delete image file if it exists
            if (!empty($profile->image)) {
                File::delete(public_path('/uploads/profiles/' . $profile->image));
            }

            // Delete attachment file if it exists
            if (!empty($profile->attached)) {
                File::delete(public_path('/uploads/attached/' . $profile->attached));
            }

            // Delete the profile record
            $profile->delete();

            return response()->json(['message' => 'Profile deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete profile: ' . $e->getMessage()], 500);
        }
    }



    public function profile_search(Request $request)
    {

        $page = $request->input('page', 1);

        $output = '';
        $profiles = Profiles::where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('address', 'like', '%' . $request->search . '%')
                            ->paginate(10, ['*'], 'page', $page);

        // foreach ($profiles as $profiles) {

        //     $imageTag='';
        //     if(!is_null($profiles->image)){
        //         $imageUrl= asset('uploads/profiles/' . $profiles->image);
        //         $imageTag= '<img style="border-radius: 50%" src="' . $imageUrl . '" alt="No Image Found" width="50px" height="50px">';

        //     }
        //     $attachedTag='';
        //     if(!is_null($profiles->attached)){
        //         $attachedUrl= asset('uploads/attached/' . $profiles->attached);
        //         $attachedTag= '<a href="' . $attachedUrl . '" class="btn btn-lg "><i class="bi bi-file-earmark-arrow-down-fill h4"></i></a>';
        //     }


        //     $actionsTag = '
        //     <div class="d-flex align-items-center">
        //         <a href="' . route('profiles.edit', $profiles->id) . '" class="btn btn-sm">
        //             <i class="bi bi-pencil-square h4"></i>
        //         </a>
        //         <form action="' . route('profiles.destroy', $profiles->id) . '" method="post" style="display:inline;">
        //             ' . csrf_field() . '
        //             ' . method_field('delete') . '
        //             <button type="submit" onclick="return confirmDelete(' . $profiles->id . ');" class="btn btn-sm text-danger">
        //                 <i class="bi bi-trash h4"></i>
        //             </button>
        //         </form>
        //     </div>
        // ';




        //     $output.=
        //     '<tr>
        //         <td>'.$profiles->id.'</td>
        //         <td>'.$profiles->name.'</td>
        //         <td>'.$profiles->email.'</td>
        //         <td>'.$profiles->phone.'</td>
        //         <td>'.$profiles->address.'</td>
        //         <td>'.$imageTag.'</td>
        //         <td>'.$attachedTag.'</td>
        //         <td>'.$actionsTag.'</td>

        //     </tr>';
        // }

        return response()->json($profiles);
    }



}
