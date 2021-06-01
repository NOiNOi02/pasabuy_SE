<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\shoppingList;
use Illuminate\Support\Facades\Auth;

class RequestPost extends Model
{
    use HasFactory;

    protected $table = 'tbl_orderRequestPost';
    protected $fillable = [
    	'postNumber',
    	'postStatus',
    	'deliveryAddress',
    	'shoppingPlace',
    	'deliverySchedule',
    	'paymentMethod',
    	'shoppingListNumber',
    	'caption'
    ];

    public $timestamps = false;
    public $primaryKey = 'indexOrderRequestPost';

    // public static function boot()
    // {
    //     parent::boot();
    //     self::creating(function ($model) {
    //         $model->shoppingListNumber = '076-'.str_pad(Auth::user()->indexUserAuthentication,4,'0',STR_PAD_LEFT).'-'.str_pad(ShoppingList::count()+1,5,'0',STR_PAD_LEFT);
    //     });
    // }

    /**
     *    [post description]
     *    @author Al Vincent Musa
     *    @return [type] [description]
     */
    public function post() {
		return $this->belongsTo(Post::class, 'postNUmber', 'postNumber');    	
    }

    public function shoppingList(){
      return $this->hasOne(shoppingList::class, 'shoppingListNumber', 'shoppingListNumber');
    }
}
