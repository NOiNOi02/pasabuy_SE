<?php

namespace App\Http\Controllers;

use App\Mail\emailConfirmation;
use App\Models\User;
use App\Models\Messages;
use App\Models\userAddress;
use App\Models\userid;
use App\Models\userInformation;
use App\Models\userLanguages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManagerStatic as Image;

class userInformationController extends Controller
{
    //
    public function getPersonal()
    {
        # code...
        $user = Auth::user();
        $data = DB::select('SELECT * FROM tbl_userInformation WHERE  email = \''.$user->email.'\'');
        // $data[0]->profilePicture= Storage::url($data[0]->profilePicture);
        // $data[0]->profilePicture= Storage::disk('s3')->response($data[0]->profilePicture);
        return response()->json($data[0]);
    }

    public function getAddress()
    {
        # code...
        $user = Auth::user();
        $data = DB::select('SELECT * FROM tbl_userAddress WHERE email = \''.$user->email.'\'');
    
        if($data == null)
            return response()->json('');
        return response()->json($data[0]);
    }

    public function getLanguages()
    {
        # code...
        $user = Auth::user();
        $data = DB::select('SELECT * FROM tbl_languages ORDER BY  languages');
        if($data == null)
            return response()->json([]);
        return response()->json($data);
    }

    public function getWorks()
    {
        # code...
        $user = Auth::user();
        $data = DB::select('SELECT * FROM tbl_work ORDER BY  work');
        if($data == null)
            return response()->json([]);
        return response()->json($data);
    }

    public function getAllLanguages()
    {
        # code...
        return userLanguages::all();
    }

    public function getValidID()
    {
        # code...
        $user = Auth::user();
        $data = DB::select('SELECT * FROM tbl_userID WHERE email = \''.$user->email.'\'');

        if($data == null)
            return response()->json('');
        return response()->json($data[0]);
    }

     public function confirmUser(Request $request)
    {
        # code...
        $validator=Validator::make($request->all(),[
            'password' => ['required'],
            'email' => ['required','email','unique:tbl_userAuthentication']
       ]);
        if($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $hashedPassword = Auth::user()->getAuthPassword();
        if (Hash::check( $request->password,  $hashedPassword)) {
            $code = mt_rand(100000, 999999);
            $data =[
                'name' => $request->firstName,
                'verification_code' =>  $code
            ];
            $email = trim($request->email);   
            $returnValue = ['code'=>Hash::make($code) ];
            if($request != null){
                Mail::to($email)->send(new emailConfirmation($data));
                return response()->json($returnValue,200);
            }
            return response()->json(['error'=>'An error occured'],422);
        }else{
            return response()->json(['password'=>'Incorrect Password'],422);
        }
    }

    public function changeEmail(Request $request)
    {
        # code...
        if (Hash::check( $request->typeCode,  $request->code)){
            $user = userInformation::where('email',Auth::user()->email)->first();
            $user->email = $request->email;
            if($user->save()){
                return response()->json(['message'=>'Successfully changed email'],200);
            }else{
                return response()->json(['error'=>'An error occured'],422);
            }
           
        }else{
            return response()->json(['error'=>'Incorrect Code'],422);
        }

    }

    public function changePassword(Request $request)
    {
        # code...
        $messages = ['password.regex' => ' Must contain at least one lowercase letter (a – z).
                        Must contain at least one uppercase letter (A – Z).
                        Must contain at least one digit (0-9).'
                    ];
        $validator=Validator::make($request->all(),[
            'currentPassword' => ['required'],
            'password' => ['required',
                            'confirmed',
                            'min:8',
                            'regex:/[a-z]/',      // must contain at least one lowercase letter
                            'regex:/[A-Z]/',      // must contain at least one uppercase letter
                            'regex:/[0-9]/',      // must contain at least one digit
                        ],],$messages);
        if($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $hashedPassword = Auth::user()->getAuthPassword();
        if (Hash::check( $request->currentPassword,  $hashedPassword)){
            $user = User::where('email',Auth::user()->email)->first();
            $user->password = Hash::make($request->password);
            if($user->save()){
               return response()->json(['message'=>'Successfully changed password'],200);
            }else{
                return response()->json(['error'=>'An error occured'],422);
            }
        }else{
            return response()->json(['password'=>'Incorrect current password'],422);
        }

    }

    public function updateProfilePic(Request $request)
    {
        # code...
        $validator=Validator::make($request->all(),[
            'photo' => 'required|file|image',
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $user = userInformation::where('email',Auth::user()->email)->first();

        $image = $request->file('photo');
        $file_name = $request->file('photo')->hashName();
        $image_resize = Image::make($image)->fit(500,500); 

        Storage::disk('s3')->put('/images/'.$user->indexUserInformation.'/avatar/'.$file_name, $image_resize->stream(),'public');
 
        $user->profilePicture = Storage::disk('s3')->url('images/'.$user->indexUserInformation.'/avatar/'.$file_name);
        if($user->save()){
            return response()->json(['message'=>'Profilce Picture successfully changed.'],200);
        }else{
            return response()->json(['error'=>'Something went wrong'],422);
        }
        
    }

    public function editPersonal(Request $request)
    {
        # code...
        $validator=Validator::make($request->all(),[
            'firstname' => ['required','regex:/^[\pL\s\-]+$/u','max:255'],
             'lastname' => ['required','regex:/^[\pL\s\-]+$/u','max:255'],
             'phone_number' =>  ['required','regex:(\+?[6][3]?\s?[9]\d{2}\s?\d{3}\s?\d{4})'],
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

       

        //updating userinfo table
        $userEmail = Auth::User()->email;
        $user = userInformation::where('email',$userEmail)->first();
        $user->firstName = $request->firstname;
        $user->middleName = $request->middlename;
        $user->lastName = $request->lastname;
        $user->phoneNumber = $request->phone_number;
        $user->gender = $request->gender;
        $user->birthDate = $request->birdate;

        echo "".$request->workList."";
        // if($request->workList!=null)
        //  $user->work = implode("," , $request->workList);
        // else
        //  $user->work = null;
        if($request->workList=="")
        $user->work = null;
        else
        $user->work = $request->workList;
        if($request->languagesList=="")
        $user->language = null;
        else
        $user->language = $request->languagesList;

       
        if($user->save()){
        }
        else{
            return response()->json('error, information not saved');
        }

    }
    public function getUserInfo(Request $request)
    {
        # code...
        $data = DB::select('SELECT * FROM tbl_userInformation WHERE  email = \''.$request->email.'\'');
        // $data[0]->profilePicture= Storage::disk('s3')->response($data[0]->profilePicture);
        return response()->json($data[0]);
    }

    public function postID(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(),[
            'front_image' => ['image','max:25000','required'],
            'back_image' =>  ['image','max:25000','required'],
        ]);
        if($validator->fails()) {
            return response()->json($validator->errors(),422);
        }
        $userInfo = userInformation::where('email', Auth::user()->email)->first();
        if (($request->file('front_image') != NULL) && ($request->file('back_image') != NULL)) {
            $user = new userid();
            $user->email = $userInfo->email;
            // $image = $request->file('front_image');
            // $file_name = $request->file('front_image')->hashName();
            // $image_resize = Image::make($image->getRealPath());
            // $image_resize->save(public_path('storage\images\\' . $request->indexUserInformation . '\\' . $file_name))->fit(500, 500);


            // $user->IDFrontPicture = Storage::url('/images/' . $request->indexUserInformation . '/' . $file_name);

            $image = $request->file('front_image');
            $file_name = $request->file('front_image')->hashName();
            $image_resize = Image::make($image);
    
            Storage::disk('s3')->put('/images/'.$userInfo->indexUserInformation.'/validID/Front/'.$file_name, $image_resize->stream(),'public');
     
            $user->IDFrontPicture = Storage::disk('s3')->url('images/'.$userInfo->indexUserInformation.'/validID/Front/'.$file_name);

            // $image = $request->file('back_image');
            // $file_name = $request->file('back_image')->hashName();
            // $image_resize = Image::make($image->getRealPath());
            // $image_resize->save(public_path('storage\images\\' . $request->indexUserInformation . '\\' . $file_name))->fit(500, 500);

            // $user->IDBackPicture = Storage::url('/images/' . $request->indexUserInformation . '/' . $file_name);


            $image = $request->file('back_image');
            $file_name = $request->file('back_image')->hashName();
            $image_resize = Image::make($image);
    
            Storage::disk('s3')->put('/images/'.$userInfo->indexUserInformation.'/validID/Back/'.$file_name, $image_resize->stream(),'public');
     
            $user->IDBackPicture = Storage::disk('s3')->url('images/'.$userInfo->indexUserInformation.'/validID/Back/'.$file_name);

            $user->save();

            return 'ok';
        }
        return 'not ok';
    }
  

}
