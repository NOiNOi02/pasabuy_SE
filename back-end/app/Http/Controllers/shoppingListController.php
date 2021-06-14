<?php

namespace App\Http\Controllers;

use App\Models\shoppingList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class shoppingListController extends Controller
{
    //
    public function getShoppingList()
    {
        # code...
        // $data = DB::select('SELECT * FROM tbl_shoppingList WHERE email = \''.Auth::user()->email.'\'');
        // return $data[0];
        $data = DB::table('tbl_shoppingList')->where('email', '=', Auth::user()->email)->get();
        for ($i = 0; $i < $data->count(); $i++) {
            $data[$i]->shoppingListContent = json_decode($data[$i]->shoppingListContent);
        }
        return $data;
    }
    public function editList(Request $request, $listNum)
    {
        # code...
        // $data = DB::select('SELECT * FROM tbl_shoppingList WHERE email = \''.Auth::user()->email.'\'');
        // return $data[0];
        $validator = Validator::make($request->all(), [
            'list' => 'required',
            'listName' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = shoppingList::where('shoppingListNumber', $listNum)->first();
        if (($data->shoppingListTitle == $request->listName) && ($data->shoppingListContent == json_encode($request->list))) {
            return response()->json(["success" => "no changes"], 201);
        } else {
            if (DB::table('tbl_shoppingList')->where('email', '=', Auth::user()->email)->where('shoppingListNumber', $listNum)->update(["shoppingListContent" => json_encode($request->list), 'shoppingListTitle' => $request->listName, "dateModified" => Carbon::now('Asia/Manila')])) {
                $selectedList = shoppingList::where('shoppingListNumber', $listNum)->first();
                $selectedList->shoppingListContent = json_decode($selectedList->shoppingListContent);
                return response()->json($selectedList, 201);
            } else {
                return response()->json(["error" => "error in updating list"], 422);
            }
        }
    }
    public function deleteList($listNum)
    {
        # code...
        // $data = DB::select('SELECT * FROM tbl_shoppingList WHERE email = \''.Auth::user()->email.'\'');
        // return $data[0];

        if (shoppingList::where('shoppingListNumber', '=', $listNum)->delete()) {
        } else {
            return response()->json(["error" => "error in delete list"], 422);
        }
    }
    public function createList(Request $request)
    {
        # code...
        // $data = DB::select('SELECT * FROM tbl_shoppingList WHERE email = \''.Auth::user()->email.'\'');
        // return $data[0];
        $validator = Validator::make($request->all(), [
            'list' => 'required',
            'listName' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $insertList = DB::table('tbl_shoppingList')->where('email', '=', Auth::user()->email)->insert(["dateModified" => Carbon::now('Asia/Manila'), "shoppingListContent" => json_encode($request->list), "shoppingListTitle" => $request->listName, 'shoppingListNumber' => '076-' . str_pad(Auth::user()->indexUserAuthentication, 4, '0', STR_PAD_LEFT) . '-' . str_pad(shoppingList::count() + 1, 5, '0', STR_PAD_LEFT), 'email' => Auth::user()->email]);
        if ($insertList) {
            $selectedList = shoppingList::where('shoppingListNumber', '076-' . str_pad(Auth::user()->indexUserAuthentication, 4, '0', STR_PAD_LEFT) . '-' . str_pad(shoppingList::count(), 5, '0', STR_PAD_LEFT))->first();
            $selectedList->shoppingListContent = json_decode($selectedList->shoppingListContent);
            return response()->json($selectedList, 201);
        } else {
            return response()->json(["error" => "error in updating list"], 422);
        }
    }
}
