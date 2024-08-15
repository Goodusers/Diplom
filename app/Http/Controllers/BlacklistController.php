<?php

namespace App\Http\Controllers;

use App\Models\Blacklist;
use Illuminate\Http\Request;

class BlacklistController extends Controller
{
    public function blacklist(Request $request){
        Blacklist::create([
            'user_id' => $request['user_id'],
            'friend_id' => $request['chat_id'],
            'chat_id' => $request['friend_id']
        ]);
        return redirect()->back();
    }
    public function unblacklist(Request $request){
        $del = Blacklist::where('chat_id', $request->chats_id);
        $del -> delete($request->chats_id);
        return redirect()->back();

    }
}
