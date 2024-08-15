<?php 
namespace App\Http\Controllers;
use App\Mail\newPassMail;
use App\Mail\passMail;
use App\Models\Chat;
use App\Models\Friend;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function count_friends($value){ // Количество друзей 
        $result = 0;
        for( $i = 0; $i < count($value); $i++){
            if(count($value) == 0){
                $result = 0;
            }else{
                $result += 1;
            }
        }
        return $result;
    }
    public function account($username){ // Личный кабинет
        $user = User::findOrFail(Auth::user()->id);
        if($user->is_blocked == 0){
            $sum_friend = Friend::where(function ($query) {
                $query->where('user_id', Auth::user()->id)->orWhere('friend_id', Auth::user()->id);
            })->where('status', 'accepted')->select('id')->get();
            $one_app = DB::table('friends')->join('users', 'users.id', '=', 'friends.user_id')->where('status', 'accepted')->where('friends.friend_id', Auth::user()->id)->get(['users.id as user_id', 'friends.id as id', 'friends.status' ,'users.username', 'users.photo', 'users.is_service']);
            $two_app = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->where('status', 'accepted')->Where('friends.user_id', Auth::user()->id)->get(['users.id as user_id', 'friends.id as id', 'friends.status', 'users.username', 'users.photo', 'users.is_service']);
            $app = $two_app->merge($one_app);
            $result = $this -> count_friends($sum_friend);
            $photo = DB::table('users')->join('photos', 'photos.user_id', '=', 'users.id')->where('photos.user_id', Auth::user()->id)->orderBy('photos.created_at', 'desc')->select('users.id as users_id', 'photos.photo', 'photos.created_at as create', 'photos.id as photos_id')->get();
            return view('layouts.account.account', ['user' => $user, 'photo' => $photo, 'app' => $app,'result'=>$result]);
        }
        else
        {
            return view('layouts.account.blocked_page_user');
        }
    }
    public function chats(){ // Чаты

        $last_message = DB::table('users')->join('messages', 'users.id', '=', 'messages.user_id')->where('messages.user_id', '=', Auth::user()->id)->orderBy('messages.created_at', 'DESC')->get();
        $two_last_message = DB::table('users')->join('messages', 'users.id', '=', 'messages.friend_id')->where('messages.friend_id', '=', Auth::user()->id)->orderBy('messages.created_at', 'DESC')->get();
        $result_last_meesage_merge = $last_message->merge($two_last_message);

        $user = DB::table('users')->join('messages', 'users.id', '=', 'messages.user_id')->where('messages.user_id', '=', Auth::user()->id)->get();
        $user_two = DB::table('users')->join('messages', 'users.id', '=', 'messages.friend_id')->where('messages.user_id', '=', Auth::user()->id)->get();
        $result_user_merge = $user->merge($user_two);
        $result_all_query = $result_last_meesage_merge->merge($result_user_merge);
        $user = $result_all_query->unique('username');

        if(count($user) == 0){
                return view('layouts.account.myChats', ['user' => $user]);   
            if(count($user) == 0 ){
                $user = User::findOrFail(Auth::user()->id);
                return view('layouts.account.myChats', ['not_users' => $user]);   
            }
        }
        else{
            return view('layouts.account.myChats', ['user' => $user]);
        }
    }
    public function friends($id){ // Друзья
        $admin = User::all();
        $user = User::findOrFail(Auth::user()->id);
        $one_app = DB::table('friends')->join('users', 'users.id', '=', 'friends.user_id')->where('status', 'pending')->where('friends.friend_id', $id)->get(['users.id as user_id', 'friends.id as id', 'friends.status' ,'users.username', 'users.photo']);
        $two_app = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->where('status', 'pending')->Where('friends.friend_id', $id)->where('friends.friend_id', '!=', Auth::user()->id)->get(['users.id as user_id', 'friends.id as id', 'friends.status', 'users.username', 'users.photo']);
        $app = $two_app->merge($one_app);
        $friend_one = DB::table('friends')->join('users', 'users.id', '=', 'friends.user_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['friends.status', '=', 'accepted'], ['friends.friend_id', '=', $id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
        $friend_two = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['friends.status', '=', 'accepted'], ['friends.user_id', '=', $id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
        $collection = collect($friend_one);
        $friend = $collection->merge($friend_two);
        $unique_friends = $friend->unique('id');
        $unique_friends = $unique_friends->values();
        if(count($friend) == 0){
            return view('layouts.account.friends', ['user' => $user, 'friend' => $unique_friends, 'pending' => $app, 'admin' => $admin]);
        }
        return view('layouts.account.friends', ['user' => $user, 'friend' => $unique_friends, 'pending' => $app, 'admin' => $admin]);
    }
    public function filter_friends(Request $request){ // Фильтрация всех пользователей в статусе "Друг"
        $app = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->where('status', 'pending')->Where('friends.friend_id', Auth::user()->id)->get(['users.id as user_id', 'friends.id as id', 'friends.status', 'users.username', 'users.photo']);
        $user = User::findOrFail(Auth::user()->id);
        if($request->all_users){
            $friend = User::all()->where('id', '!=', Auth::user()->id   );
            return view('layouts.account.friends', ['user' => $user, 'friend' => $friend, 'pending' => $app]);
        }
    }
    public function filter_my_friends(Request $request){ // Фильтрация друзей авторизированного пользователя
        if($request->my_friends){
            $user = User::findOrFail(Auth::user()->id);
            $app = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->where('status', 'pending')->Where('friends.friend_id', Auth::user()->id)->get(['users.id as user_id', 'friends.id as id', 'friends.status', 'users.username', 'users.photo']);
            $friend_one = DB::table('friends')->join('users', 'users.id', '=', 'friends.user_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['friends.status', '=', 'accepted'], ['friends.friend_id', '=', Auth::user()->id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
            $friend_two = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->join('chats', 'friends.id', '=', 'chats.friend_id')->where([['friends.status', '=', 'accepted'], ['friends.user_id', '=', Auth::user()->id]])->get(['chats.id as my_chats_id', 'users.id as id', 'users.username', 'users.is_service', 'users.token', 'users.photo', 'friends.user_id', 'friends.friend_id', 'friends.status']);
            $collection = collect($friend_one);
            $friend = $collection->merge($friend_two);
            $unique_friends = $friend->unique('id');
            $unique_friends = $unique_friends->values();
            if(count($friend) == 0){
                $app = DB::table('friends')->join('users', 'users.id', '=', 'friends.user_id')->where('status', 'pending')->Where('friends.friend_id', Auth::user()->id)->get(['users.id as user_id', 'friends.id as id', 'friends.status' ,'users.username', 'users.photo']);
                return view('layouts.account.friends', ['user' => $user, 'friend' => $unique_friends, 'pending' => $app]);
            }
            return view('layouts.account.friends', ['user' => $user, 'friend' => $unique_friends, 'pending' => $app]);
        }
    }
    public function change_my_data(Request $request){ // Обработка изменений личных данных
        $change_data = User::findOrFail(Auth::user()->id);
        $change_data -> username = $request->username;
        $change_data -> phone = $request->phone;
        $change_data -> email = $request->email;
        $change_data -> token = $request->token;
        $change_data -> city = $request->city;
        if(empty($request->photo)){
            $change_data->photo = Auth::user()->photo;
            $change_data -> save();
            return redirect()->back();
        }
        else{
            $change_data -> photo = $request->photo; 
            $change_data -> save();
            return redirect()->back();
        }
    }
    public function add_my_photo(Request $request){ // Добавление фотографий в личный кабинет
        $validate = $request->validate([
            "file" => ["required"],
        ], [
            "file.required" => "Обязательное поле",
        ]);
        Photo::create([
            "user_id" => Auth::user()->id,
            "photo" => $validate['file']
        ]);
        return redirect()->back();
    }
    public function delete_photo($id){ // Удаление фотографий из личного кабинета
       $del = Photo::findOrFail($id);
       $del->delete();
       return redirect()->back();
    }
    public function search(Request $request){ // Поиск по токену
        $fd = user::all()->where('token', $request->search );
        if(collect($fd)->count()>0){
            foreach($fd as $item){
                if($item->id != Auth::user()->id){
                    return redirect()->route('account_friend', [$item->id]);
                }
                else{
                    return redirect()->back();
                }
            }
        }
        else{
            return redirect()->back();
        }
    }
    public function add_friends(Request $request){ // Добавление в "друзья"
        Friend::create([
            'user_id' => Auth::user()->id,
            'friend_id' => $request->friend_id
        ]);
        return redirect()->back();
    }
    public function update_friends(Request $request){ // Обработка запроса принимающего в друзья
        $update_id = Friend::where('id',$request->id)->where('status', 'pending')->get();
        foreach($update_id as $update){
            $update->status = 'accepted';
            $update->save();
        }
        Chat::create([ // После добавления в друзья создается чат 
            'friend_id' => $request->id,
        ]);
        return redirect()->back();
    }
    public function cancel_friends(Request $request){ // Отклонение заявки 
        $update_id = Friend::where('id',$request->id)->where('status', 'pending')->get();
        foreach($update_id as $update){
            $update->status = 'declined';
        }
        return redirect()->back();
    }
    public function del_friends(Request $request){ // Удаление из друзей
        $delete = Friend::findOrFail($request->id);
        $delete->delete($request->id);  
        $delete = Chat::findOrFail($request->id);
        $delete->delete();  
        return redirect()->back();
    }
    public function account_friend($id){ // Кабинет друга
        $info_friends_one = Friend::where([ ['user_id', '=', $id], ['friend_id', '=', Auth::user()->id]])->get(); //Получаем первую коллекцию 
        $info_friends_two = Friend::where([ ['friend_id', '=', $id], ['user_id', '=', Auth::user()->id]])->get(); // Получаем вторую коллекцию
        $result_merge = $info_friends_two->merge($info_friends_one); // Объедеинение результатов 
        $id_account = $id;
        $one_app = DB::table('friends')->join('users', 'users.id', '=', 'friends.user_id')->where('status', 'accepted')->where('friends.friend_id', $id)->get(['users.id as user_id', 'friends.id as id', 'friends.status' ,'users.username', 'users.photo', 'users.is_service']);
        $two_app = DB::table('friends')->join('users', 'users.id', '=', 'friends.friend_id')->where('status', 'accepted')->Where('friends.user_id', $id)->get(['users.id as user_id', 'friends.id as id', 'friends.status', 'users.username', 'users.photo', 'users.is_service']);
        $app = $two_app->merge($one_app);
        $user = User::findOrFail($id);
        $photo = DB::table('users')->join('photos', 'photos.user_id', '=', 'users.id')
        ->where('photos.user_id', $id)
        ->select('users.id as users_id', 'photos.photo', 'photos.created_at as create', 'photos.id as photos_id')->get();
        $friend = DB::table('friends')
        ->leftJoin('users as users_friend', 'users_friend.id', '=', 'friends.friend_id')
        ->leftJoin('users as users_user', 'users_user.id', '=', 'friends.user_id')
        ->select('users_friend.id as friend_id','users_friend.username as friend_username','users_friend.token as friend_token','users_friend.is_service as friend_is_service','users_friend.photo as friend_photo','users_friend.city as friend_city','users_user.id as user_id','users_user.username as user_username','users_user.token as user_token','users_user.is_service as user_is_service','users_user.photo as user_photo','users_user.city as user_city','friends.friend_id','friends.id as main_id','friends.user_id','friends.status')->where('friends.friend_id', $id_account)->orWhere('friends.user_id', $id_account)->get();
        $sum_friend = Friend::where('friend_id', $id)->where('status', 'accepted')->select('id')->get();
        $two_sum_friend = Friend::where('user_id', $id)->where('status', 'accepted')->select('id')->get();
        $merge_sum_friend = $sum_friend->merge($two_sum_friend);
        $result = $this -> count_friends($merge_sum_friend);
            if(count($friend) == 0){
                $friends = $user;
                return view('layouts.account.account_friend', ['user'=>$user,'friend' => $friends, 'app' => $app, 'result_merge' => $result_merge ,'photo'=>$photo, 'result' => $result]);
            }
            else{
                foreach($friend as $friends){
                    return view('layouts.account.account_friend', ['user'=>$user, 'photo'=>$photo, 'app' => $app, 'result_merge' => $result_merge, 'friend' => $friends, 'result' => $result]);
                }
            }
        $sum_friend = Friend::where('user_id', $id)->where('status', 'accepted')->select('id')->get();
        $result = $this -> count_friends($sum_friend);
        foreach($friend as $friends){
            return view('layouts.account.account_friend', ['user'=>$user, 'photo'=>$photo, 'app' => $app, 'result_merge' => $result_merge, 'friend' => $friends, 'result' => $result]);
        }
    }
    public function blocked(Request $request){ // Блокировка пользователя
        $blocked = User::findOrFail($request->id);
        $blocked -> is_blocked = 1;
        $blocked -> save();
        return redirect()->back();
    }
    public function not_blocked(Request $request){ // Разблокировка пользователя
        $blocked = User::findOrFail($request->id);
        $blocked -> is_blocked = 0;
        $blocked -> save();
        return redirect()->back();
    }
    public function resetPassword(Request $request){ // Смена пароля
        $validate = $request->validate([
            'two_email' => ['required', 'email', 'regex:/@(gmail|email|yandex|ya|mail)/']
        ],[
            'two_email.required' => "Обязательное поле",
            'two_email.email' => "Необходим знак @",
            'two_email.regex' => "Неизвестный формат"
        ]);
        $userEmail = User::where('email', $request->two_email)->get();
        if(count($userEmail) > 0){
            $title = 'PULSE';
            $body = 'Уведомление о смене пароля';
            $code = rand(1000, 9999);
            Mail::to($validate['two_email'])->send(new passMail($title, $body, $code));
            return view('code', ['code_password' => $code, 'email' => $request->two_email]);
        }else{
            return redirect()->back()->withErrors(['email'=>'Не удалось получить данные']);
        }
    }
    public function password_accepted(Request $request){ // Подтверждение кода
        $validate = $request->validate([
            'get_code_password' => ['required', 'min:4']
        ],[
            'get_code_password.required' => 'Обязательное поле',
            'get_code_password.min' => 'Минимум 4 символов'
        ]);
        if($validate['get_code_password'] == $request->code_password){
            $title = 'PULSE';
            $body = 'Уведомление о смене пароля';
            $pwd = bin2hex(openssl_random_pseudo_bytes(4));
            Mail::to($request->email)->send(new newPassMail($title, $body, $pwd));
            $data = User::where('email', $request->email)->first();
            $data->password = $pwd;
            $data->save();
            return redirect('/');   
        }
        else{
            return redirect('/')->withErrors(['email'=>'Не удалось получить данные']);
        }
    }
}
