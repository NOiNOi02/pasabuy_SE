<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;
use App\Models\userInformation;
use Illuminate\Support\Facades\DB;

class messageController extends Controller
{
    
    //
    public function getChatroom()
    {
        # code...

        return DB::select( DB::raw("SELECT firstName,lastName,email FROM `tbl_userinformation` INNER JOIN tbl_message ON tbl_message.email1 = tbl_userinformation.email OR tbl_message.email2 = tbl_userinformation.email WHERE tbl_message.email1 = 'mikasa@gmail.com' or tbl_message.email2 = 'mikasa@gmail.com' ORDER BY tbl_message.dateCreated DESC") );
        // return userInformation::select('firstName','lastName','email','dateCreated')
        //                         ->join('tbl_message', 'tbl_message.email1','=', 'tbl_userInformation.email')
        //                         ->orOn('tbl_message.email2', '=', 'tbl_userInformation.email')
        //                         ->Where('tbl_message.email1', '=', Auth::user()->email)
        //                         ->orWhere('tbl_message.email2', '=', Auth::user()->email)
        //                         ->orderBy('dateCreated', 'DESC')->get();
    }

    public function getMessages(Request $request)
    {
        # code...
        return Messages::where('email1', '=', Auth::user()->email)
                                        ->Where('email2', '=', $request->email)
                                        ->orWhere('email1', '=', $request->email)
                                        ->Where('email2', '=',Auth::user()->email)
                                        ->orderBy('dateCreated', 'ASC')->get();
    }

    public function sendMessage(Request $request)
    {
        # code...   
        $messageCount = Messages::count();
        $newMessage = new Messages;
        $newMessage->email1 = Auth::user()->email;
        $newMessage->email2 = $request->email;
        $newMessage->message =$request->message;
        $newMessage->messageNumber = $messageCount.'-Message';
        $newMessage->save();
        
    }
}
