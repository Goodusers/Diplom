<?php

namespace App\Http\Controllers;

use App\Events\CommunityMessageSent;
use App\Models\Community;
use App\Models\MessageCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class CommunityController extends Controller
{
    public function friends(){
        $friend_one = DB::table('friends')->join('users', 'users.id', '=', 'friends.user_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['status', '=', 'accepted'], ['friends.friend_id', '=', Auth::user()->id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
        $friend_two = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['status', '=', 'accepted'], ['friends.user_id', '=', Auth::user()->id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
        $collection = collect($friend_one);
        $friend = $collection->merge($friend_two);
        $unique_friends = $friend->unique('id');
        return $unique_friends = $unique_friends->values();
    }
    public function all_community(){
        $one_collection = DB::table('communities')->join('users', 'users.id', '=', 'communities.user_id')->where([ ['communities.author_id', '=', Auth::user()->id]])->get(['users.username', 'users.photo as user_photo', 'users.id as user_id', 'communities.id', 'communities.photo', 'communities.title', 'communities.name']);
        $two_collection = DB::table('communities')->join('users', 'users.id', '=', 'communities.user_id')->where([ ['communities.user_id', '=', Auth::user()->id]])->get(['users.username', 'users.photo as user_photo', 'users.id as user_id', 'communities.id', 'communities.photo', 'communities.title', 'communities.name']);
        $community = $one_collection->merge($two_collection);
        $unique_community = $community->unique('title');
        return $unique_community = $unique_community->values();
    }
    public function community(){
        $unique_friends = $this->friends();
        $unique_community = $this->all_community();
        return view('layouts.account.mCommunity', ['friends' => $unique_friends, 'community' => $unique_community]);
    }
    public function create_community(Request $request){
        $validate = $request->validate([
            'user_id' => ['required']
        ],[
            'user_id.required' => 'хотябы один пользователь'
        ]);
        if($request->user_id){
            $title = bin2hex(openssl_random_pseudo_bytes(4));
            foreach($validate['user_id'] as $itemInput){
                if($request->photo == null){
                    $photo = 'happy.png';
                }
                else{
                    $photo = $request->photo;
                }
                if($request->name == null){
                    $name = 'Новое сообщество';
                }
                else{
                    $name = $request->name;
                }

                Community::create([
                    'author_id' => $request->author_id,
                    'name' => $name,
                    'title' => $title,
                    'photo' => $photo,
                    'user_id' => $itemInput
                ]);
            }
            return redirect()->back();
        }return redirect(route('community'))->withErrors(['user_id'=>'хотябы один пользователь']);
    }
    public function community_page($title)
    {
        $user_one = DB::table('users')->join('communities', 'users.id', '=', 'communities.user_id')->where('communities.title', $title)->where('communities.user_id', Auth::user()->id)->get();
        $user_two = DB::table('users')->join('communities', 'users.id', '=', 'communities.author_id')->where('communities.title', $title)->where('communities.author_id', Auth::user()->id)->get();
        $user = $user_one -> merge($user_two);

        $unique_friends_local_ids = DB::table('users')->join('communities', 'users.id', '=', 'communities.user_id')->where('communities.title', '=', $title)->pluck('users.id');
        $unique_friends = DB::table('users')->join('communities', 'users.id', '=', 'communities.user_id')->where('communities.title', '!=', $title)->whereNotIn('users.id', $unique_friends_local_ids)->get();
        $friends_not_in_community = DB::table('users')->join('friends', 'users.id', '=', 'friends.friend_id')->whereNotIn('friends.user_id', $unique_friends_local_ids)->get();
        $result = $unique_friends->merge($friends_not_in_community);
        $peopleInCommunity = count($unique_friends_local_ids) + 1;

        // Участники сообщества
        $one_users_community = DB::table('users')->join('communities', 'users.id', '=', 'communities.author_id')->where('communities.title', '=', $title)->get(['users.photo as user_photo', 'users.username', 'users.is_service', 'users.id as user_id']);
        $two_users_community = DB::table('users')->join('communities', 'users.id', '=', 'communities.user_id')->where('communities.title', '=', $title)->get(['users.photo as user_photo', 'users.username', 'users.is_service', 'users.id as user_id']);
        $users_community = $two_users_community->merge($one_users_community);
        $users_community = $users_community->unique('user_id');
        foreach($user as $use){
            return view('community', ['user' => $use, 'friends' => $result, 'users_community' => $users_community, 'count_people' => $peopleInCommunity, response()->json($use)]);  
        }
    }
    public function messages_community($title){
        return DB::table('users')->join('message_communities', 'users.id', '=', 'message_communities.user_id')->where('message_communities.title', $title)->get();
    }
    public function send_community(Request $request){
    
        $message = MessageCommunity::create([
            'user_id' => $request['user_id'], 
            'title' => $request['title'],
            'message' => $request['message'],
            'username' => Auth::user()->username,
            'user_photo' => Auth::user()->photo,
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
               
        broadcast(new CommunityMessageSent($message));

        return response()->json([ 'message' => $message], 200);
    }
    public function change_data_community(Request $request){

        $data = Community::where('communities.title',$request->title)->get();
        foreach($data as $item){
            if($request->photo == null){
                $item->name = $request->name;
                $item->save();
                return redirect()->back();
            }
            $item->photo = $request->photo;
            $item->name = $request->name;
            $item->save();
            return redirect(url('community_page/'.$request->title));
        }
    }
    public function change_data_community_addUser(Request $request){
        $validate = $request->validate([
            'user_id' => ['required']
        ],[
            'user_id.required' => 'хотябы один пользователь'
        ]);
        if($request->user_id){
            foreach($validate['user_id'] as $itemInput){

                Community::create([
                    'author_id' => $request->author_id,
                    'name' => $request->name,
                    'title' => $request->title,
                    'photo' => $request->photo,
                    'user_id' => $itemInput
                ]);
            }
            return redirect()->back();
        }
        return redirect(url('community_page/'.$request->title))->withErrors(['user_id'=>'хотябы один пользователь']);
    }
    public function del_community(Request $request){
        
        $data = Community::where('communities.title',$request->id)->get();
        foreach($data as $item){
            $item->title = $request->id;
            $item->delete();
        }
        return redirect(route('community'));

    }
    public function exit_community(Request $request){
        $data = Community::where('communities.user_id', Auth::user()->id)->pluck('user_id');
        $data_one = Community::where('communities.title', $request->id_comm)->whereIn('user_id', $data)->get();
        $data_messages = MessageCommunity::whereIn('user_id', $data)->get();
        
        foreach($data_messages as $item_t){

            $item_t->id = $item_t->id;
            $item_t->delete();
        }
        foreach($data_one as $item){
            $item->id = $item->id;
            $item->delete();
        }

        return redirect(route('community'));

    }
    
}
