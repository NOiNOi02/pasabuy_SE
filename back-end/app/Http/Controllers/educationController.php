<?php

namespace App\Http\Controllers;
use App\Models\userEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class educationController extends Controller
{
    //
    public function getEduc()
    {
        # code...
        // return DB::select('SELECT * from tbl_usereducation WHERE email = \'' . Auth::user()->email . '\'');
        $data = DB::select('SELECT * FROM tbl_userEducation ORDER BY  schoolName');

        // $data = userAbout::all();

		return response()->json($data);
    }
    public function updateEduc(Request $request)
    {
        $request->validate([
            'email' => [],
            'schoolList' => []
        ]);

        print_r($request->schoolList);

        // echo "";
        
        for($i=0;$i<count($request->schoolList);$i++){
            echo $request->schoolList[$i]["id"] . "-";
            if($request->schoolList[$i]["version"] == null){
                $record = new userEducation;
                $record->email = $request->email;
                $record->schoolName = $request->schoolList[$i]["school"];
                $record->schoolStatus = $request->schoolList[$i]["status"];
                $record->save();
            }
            else{
                DB::table('tbl_userEducation')
                ->where('indexUserEducation', $request->schoolList[$i]["version"])
                ->update(['schoolName' => $request->schoolList[$i]["school"],'schoolStatus' => $request->schoolList[$i]["status"]]);
            }

        }
    }
}
