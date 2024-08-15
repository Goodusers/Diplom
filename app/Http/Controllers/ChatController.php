<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageFormRequest;
use App\Models\BackgroundChat;
use App\Models\Blacklist;
use App\Models\Message;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ChatController extends Controller
{
    public function chat($id)
    {
        $friend_one = DB::table('users')->join('friends', 'users.id', '=', 'friends.user_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['chats.id', '=', $id], ['friends.user_id', '!=', Auth::user()->id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
        $friend_two = DB::table('users')->join('friends', 'users.id', '=', 'friends.friend_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['chats.id', '=', $id], ['friends.friend_id', '!=', Auth::user()->id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
        $user = $friend_one->merge($friend_two);
        $user = $user->unique('my_chats_id');
        $blocked = Blacklist::where('chat_id', $id)->get();
        $user_id = DB::table('users')->join('friends', 'users.id', '=', 'friends.friend_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where('chats.id', $id)->where('friends.user_id', Auth::user()->id)->get();
        $two_user_id = DB::table('users')->join('friends', 'users.id', '=', 'friends.user_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where('chats.id', $id)->where('friends.friend_id', Auth::user()->id)->get();
        $result_merge = $user_id->merge($two_user_id);
        foreach($user as $use){
            foreach($result_merge as $idd){
                return view('chat', ['user' => $use, 'id'=> $idd->id, 'blocked'=>$blocked, response()->json($use)]);  
            }
        }
    }
    public function messages($chat_id){
        return Message::where('chat_id', $chat_id)->get();
    }
    public function send(Request $request){
        $message = Message::create([
            'user_id' => auth()->id(),
            'friend_id' => $request['friend_id'], 
            'chat_id' => $request['chat_id'],
            'message' => $request['message'],
            'image' => $request['image'],
            'file' => $request['file']
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('chat_images', 'public_root');
            $message->image = $path;
            $message->save();
        }   
        if ($request->hasFile('file')) {
            // Сохранение файла в указанную директорию
            $file = $request->file('file');
            $path = $file->store('chat_files', 'public_root'); // Сохранение файла
            // Получение только имени файла
            $filename = $file->getClientOriginalName();
            // Сохранение имени файла в базе данных
            $message->file = $filename;
            $message->save();
        }
        broadcast(new MessageSent($message));
        return response()->json([ 'message' => $message], 200);
    }
    public function del_history(Request $request){
        $delete = Message::where('chat_id',$request->chat_id);
        $delete -> delete($request->chat_id);
        return redirect()->back();
    }
}
