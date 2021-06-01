<?php

namespace App\Http\Controllers;

use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;
use App\Models\messageRoom;
use App\Models\User;
use App\Models\userInformation;
use App\Notifications\newMessageNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class messageController extends Controller
{
    
    //
    public function getChatroom()
    {
        $data = messageRoom::with('getEmail1','getEmail2','getMessages','getMessages.getMessageSender')->orderBy('dateModified', 'desc')->where('email1','=',Auth::user()->email)->orWhere('email2','=',Auth::user()->email)->get();
        
		return response()->json($data);
    }
    public function createRoom(Request $request)
    {
        $data = DB::select('SELECT * FROM tbl_messageRoom WHERE  (email1 = \''.$request->userEmail.'\' OR email2 = \''.$request->userEmail.'\') AND (email1 = \''.Auth::user()->email.'\' OR email2 = \''.Auth::user()->email.'\') ');

        if(empty($data)){
            $newdata = new messageRoom;
            $newdata->messageRoomNumber = (new messageRoom)->count()+1;
            $newdata->email1 = Auth::user()->email;
            $newdata->email2 = $request->userEmail;
            $newdata->dateModified = Carbon::now('Asia/Manila');
            $newdata->save();
            return response()->json($newdata);
        }
        $msgRoom = messageRoom::find($data[0]->messageRoomNumber);
        $msgRoom = messageRoom::where('messageRoomNumber',$data[0]->messageRoomNumber)->first();
        $msgRoom->dateModified = Carbon::now('Asia/Manila');
        $msgRoom->save();
        return response()->json($msgRoom);
    }

    public function sendMessage(Request $request)
    {
        # code...   
        $messageCount = Messages::count();
        $newMessage = new Messages;
        $newMessage->messageRoomNumber = $request->roomID;

        if($request->transaction != null){
            if($request->transaction){
                $newMessage->messageSender = $request->transactionSender;
            }
            else{
                $newMessage->messageSender = Auth::user()->email;
            }
        }else{
            $newMessage->messageSender = Auth::user()->email;
        }
        $newMessage->messageText =$request->message;
        $newMessage->messageNumber = $messageCount.'-Message';
        if($newMessage->save()){
            $msgRoom = messageRoom::find($request->roomID);
            $msgRoom = messageRoom::where('messageRoomNumber',$request->roomID)->first();
            $msgRoom->dateModified = Carbon::now('Asia/Manila');
            $msgRoom->save();
            if($msgRoom->email1 === Auth::user()->email){
                $userToNotif = User::where('email',$msgRoom->email2)->first();
            }else{
                $userToNotif = User::where('email',$msgRoom->email1)->first();
            }
            $userToNotif = User::find($userToNotif->indexUserAuthentication);
			$userToNotif->notify(new newMessageNotification());
        }
        
        broadcast(new NewChatMessage($newMessage))->toOthers();
        //return te current state of chat room / messages so that the client will not request for the current version/state of chats
        $data = messageRoom::with('getEmail1','getEmail2','getMessages','getMessages.getMessageSender')->orderBy('dateModified', 'desc')->where('email1','=',Auth::user()->email)->orWhere('email2','=',Auth::user()->email)->get();
        
		return response()->json($data);
    }
}
