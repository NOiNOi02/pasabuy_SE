<?php

namespace App\Http\Controllers;
use App\Models\reviews;
use Carbon\Carbon;
use Illuminate\Http\Request;

class reviewController extends Controller
{
    public function listReviews(){
        $data = reviews::with('userreviewee', 'userreviewer')
        ->orderBy('dateCreated','desc')
        ->get();

		return response()->json($data);
    }

    public function saveReview(Request $request){
        $request->validate([
            'revieweeID' => ['required'],
            'reviewerID' => ['required'],
            'revieweeEmail' => ['required'],
            'reviewerEmail' => ['required'],
            'rate' => ['required'],
            'feedback' => [],
            'dateCreated' => [],
        ]);
        
        $record = new reviews;
        $record->reviewNumber = '082-'.str_pad($request->revieweeID,4,'0',STR_PAD_LEFT).str_pad($request->reviewerID,4,'0',STR_PAD_LEFT).'-'.str_pad(reviews::count()+1, 4, '0', STR_PAD_LEFT);
        $record->revieweeEmail = $request->revieweeEmail;
        $record->reviewerEmail = $request->reviewerEmail;
        $record->rate = $request->rate;
        $record->feedback = $request->feedback;
        $record->dateCreated = Carbon::now('Asia/Manila');
        $record->save();
    }
}
