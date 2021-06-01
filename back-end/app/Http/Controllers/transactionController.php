<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\transaction;
use App\Models\User;
use App\Models\userInformation;
use App\Notifications\cancelledRequestNotification;
use App\Notifications\confirmRequestNotification;
use App\Notifications\declinedRequestNotification;
use App\Notifications\newTransactionNotification;
use App\Notifications\UpdateRequestNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class transactionController extends Controller
{
    //
    public function createTransaction(Request $request)
    {
        # code...
        $newTransaction = new transaction;
        $user = userInformation::where('email', Auth::user()->email)->first();
        $postOwner = userInformation::where('email', $request->email)->first();
        $newTransaction->transactionNumber = '084'.str_pad($postOwner->indexUserInformation,4,'0',STR_PAD_LEFT).str_pad($user->indexUserInformation,4,'0',STR_PAD_LEFT).str_pad(transaction::count()+1, 4, '0', STR_PAD_LEFT); 
        $newTransaction->postNumber = $request->postNumber;
        $newTransaction->transactionReceiver = $request->email;
        $newTransaction->transactionData = json_encode($request->transactionData);
        $newTransaction->transactionShoppingList = json_encode($request->transactionShoppingList);
        $newTransaction->emailCustomerShopper = Auth::user()->email;
        $newTransaction->dateCreated = Carbon::now('Asia/Manila');


        if($newTransaction->save()){
            $userToNotif = User::where('email',$request->email)->get();
			$userToNotif = User::find($userToNotif[0]->indexUserAuthentication);
			$userToNotif->notify(new newTransactionNotification($request->postNumber));
            return $this->getTransaction();
        }else{
            return response()->json(['error'],422);

        }

    }
    public function editListDeliverStatus(Request $request,$transNum)
    {
        # code...
        $transaction = transaction::where('transactionNumber', $transNum)->first();
        $transaction->transactionShoppingList = $request->list;
        if($transaction->save()){
            //find the right user to notify, in this case the owner of the post
        }
        else 
            return response()->json(["error"=>"Error updating transaction."],201);

    }
    public function getTransaction()
    {

        # code...
        $transaction = transaction::with('post','post.offer_post','post.request_post','post.user','post.request_post.shoppingList','transactionSender')
            ->where(function($query) {
                $query->where('emailCustomerShopper', Auth::user()->email)
                ->orWhere('transactionReceiver', Auth::user()->email);
            })->orderBy('dateCreated','desc')
              ->get();
   
        for($i=0;$i<$transaction->count();$i++){
            if (is_string($transaction[$i]->transactionData))
                $transaction[$i]->transactionData = json_decode($transaction[$i]->transactionData);
            if (is_string($transaction[$i]->transactionShoppingList))
                $transaction[$i]->transactionShoppingList = json_decode($transaction[$i]->transactionShoppingList);
        }
        
        return response()->json($transaction);
    }

    public function cancelTransaction(Request $request)
    {
          # code...
 
        $transaction = transaction::find($request->ID);
        $transaction->transactionStatus = "Cancelled";
        $transaction->dateModified = Carbon::now('Asia/Manila');

        if($transaction->save()){
            //find the right user to notify, in this case the owner of the post
			$userToNotif = Post::where('postNumber',$request->postNumber)->get();
			$userToNotif = User::where('email',$userToNotif[0]->email)->get();
			$userToNotif = User::find($userToNotif[0]->indexUserAuthentication);
			$userToNotif->notify(new cancelledRequestNotification($request->postNumber, $request->postIdentity));
            return response()->json('ok');
        }
        else 
            return response()->json('not ok');
            
    }
    public function declineRequest(Request $request)
    {
          # code...
 
        $transaction = transaction::find($request->ID);
        $transaction->transactionStatus = "Declined";
        $transaction->dateModified = Carbon::now('Asia/Manila');

        if($transaction->save()){
            //find the right user to notify, in this case the owner of the post
			$userToNotif = User::where('email',$request->userNotif)->get();
			$userToNotif = User::find($userToNotif[0]->indexUserAuthentication);
			$userToNotif->notify(new declinedRequestNotification($request->postNumber,$request->postIdentity));
            return response()->json('ok');
        }
        else 
            return response()->json('not ok');
            
    }
    public function confirmRequest(Request $request)
    {
          # code...
 
        $transaction = transaction::find($request->ID);
        $transaction->transactionStatus = "Confirmed";
        $transaction->dateModified = Carbon::now('Asia/Manila');

        if($transaction->save()){
            //find the right user to notify, in this case the owner of the post
			$userToNotif = User::where('email',$request->userNotif)->get();
			$userToNotif = User::find($userToNotif[0]->indexUserAuthentication);
			$userToNotif->notify(new confirmRequestNotification($request->postNumber, $request->postIdentity));
            if($request->postIdentity == "offer"){
                $transaction = transaction::with('post')->where('transactionStatus', 'pending')->where('postNumber', $request->postNumber)->get();
                // return  response()->json($transaction);
                if(!empty($transaction))
                foreach($transaction as $trans){
                    $trans->transactionStatus = "Declined";
                    $trans->post->postStatus = "Order Taken";
                    $trans->save();
                    $trans->post->save();
                    $userToNotif = User::where('email',$trans->emailCustomerShopper)->get();
                    $userToNotif = User::find($userToNotif[0]->indexUserAuthentication);
                    $userToNotif->notify(new declinedRequestNotification($request->postNumber, $request->postIdentity));
                }
                return response()->json('ok1');
            }
            return response()->json('ok2');
        }
        else 
            return response()->json('not ok');
            
    }
    public function updateTransaction(Request $request)
    {
        # code...
        $transaction = transaction::find($request->ID);
        $transaction->transactionStatus = $request->status;
        $transaction->dateModified = Carbon::now('Asia/Manila');

        if($transaction->save()){
            //find the right user to notify, in this case the owner of the post
			$userToNotif = User::where('email',$request->userNotif)->get();
			$userToNotif = User::find($userToNotif[0]->indexUserAuthentication);
			$userToNotif->notify(new UpdateRequestNotification($request->status,$transaction->transactionNumber));
            return response()->json(["message"=>"Transaction succesfully updated."],201);
        }
        else 
            return response()->json(["error"=>"Error updating transaction."],401);

    }
}
