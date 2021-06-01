<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class saerchController extends Controller
{
    //
    public function sarech(Request $request)
    {
        # code...
		// $data = PasabuyUser::has('post')->with('post','post.offer_post','post.request_post')->get();
		$data = Post::with('offer_post', 'request_post', 'user')->where('tbl_post.postDeleteStatus', '=', 0)->orderBy('tbl_post.dateCreated', 'desc')->get();

		for ($i = 0; $i < $data->count(); $i++) {
			if ($data[$i]->postIdentity === 'request_post')
				if (is_string($data[$i]->request_post->shoppingListContent) && $data[$i]->request_post->shoppingListContent != null )
					$data[$i]->request_post->shoppingListContent = json_decode($data[$i]->request_post->shoppingListContent);
		}
		return response()->json($data);

    }
}
