<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\shoppingOffers;
//use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class shoppingOffersController extends Controller
{
    function listShoppingOffers(){
        $data = shoppingOffers::with('posts','posts.user')
        ->whereHas('posts', function($query){
            $query->where('email', Auth::user()->email);
        })->join('tbl_post', 'tbl_shoppingOfferPost.postNumber', '=', 'tbl_post.postNumber')
        ->orderBy('tbl_post.dateCreated', 'desc')->get();
        return $data;
    }

    public function editshoppingoffers(Request $request){
        $request->validate([
            'indexShoppingOfferPost' => ['required'],
            'postNumber' => ['required'],
            'postStatus' => ['required'],
            'deliveryArea' => ['required'],
            'shoppingPlace' => ['required'],
            'deliverySchedule' => ['required'],
            'transportMode' => ['required'],
            'capacity' => ['required'],
            'paymentMethod' => ['required']
       ]);

        $record = shoppingOffers::where('indexShoppingOfferPost',$request->indexShoppingOfferPost)->first();
        $record->postNumber  = $request->postNumber ;
        $record->postStatus = $request->postStatus;
        $record->deliveryArea = $request->deliveryArea;
        $record->deliverySchedule = $request->deliverySchedule;
        $record->capacity = $request->capacity;
        $record->paymentMethod = $request->paymentMethod;
        $record->caption = $request->caption;
        $record->shoppingPlace = $request->shoppingPlace;
		$record->transportMode = $request->transportMode;
        //check if shopping place already exist in tbl_shoppingPlace
		$shoppingPlace = DB::select('SELECT * from tbl_shoppingPlace WHERE shoppingPlace = \''.$request->shoppingPlace.'\'');
		if($shoppingPlace == null){
			//save shopping place to tbl_shopping place
			DB::table('tbl_shoppingPlace')->insert([
				'shoppingPlace' => $request->shoppingPlace,
				'shoppingPlaceNumber' => '112'.str_pad(DB::table('tbl_shoppingPlace')->count() +1,6,'0',STR_PAD_LEFT),
			]);
		}
		//check if transport mode already exist in tbl_transportMOde
		$transport = DB::select('SELECT * from tbl_transportMode WHERE transportMode = \''.$request->transportMode.'\'');
		if($transport == null){
			//save transport mode to tbl_transportMode
			DB::table('tbl_transportMode')->insert([
				'transportMode' => $request->transportMode,
				'transportModeNumber' => '116'.str_pad(DB::table('tbl_transportMode')->count() +1,6,'0',STR_PAD_LEFT),
			]);
		}
        $record->save();
    }
        
}
