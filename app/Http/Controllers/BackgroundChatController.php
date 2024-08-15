<?php

namespace App\Http\Controllers;

use App\Models\BackgroundChat;
use Illuminate\Http\Request;

class BackgroundChatController extends Controller
{
    public function background(Request $request){
        $image = BackgroundChat::create([
            'user_id' => $request['users_id'],
            'image' => $request['image'],
            'chat_id' => $request['chatss_id']
        ]);
        if ($request->hasFile('image')) {
            dd($request->hasFile('image'));
            $path = $request->file('image')->store('chat_background', 'public_root');
            $image->$image = $path;
             $image->save();
        } 
        return redirect()->back();
    }
}
