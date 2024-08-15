<?php

use App\Http\Controllers\BackgroundChatController;
use App\Http\Controllers\BlacklistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\indexController;
use App\Http\Controllers\UserController;
use App\Models\Blacklist;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::controller(ChatController::class)->group(function () {
    Route::get('/chat/{id}', "chat")->middleware('auth');
    Route::get('/messages/{chat_id}', 'messages')->middleware('auth'); // Для Ajax получения cообщений
    Route::post('/send', 'send')->middleware('auth'); //Для отправки сообщения
    Route::post('/del_history', 'del_history')->name('del_history')->middleware('auth'); //Удаление истории чата
});
Route::controller(CommunityController::class)->group(function () {
    Route::get('/community', "community")->name('community')->middleware('auth'); // Все имеющиеся сообщества
    Route::get('/community_page/{title}', "community_page")->middleware('auth'); // Конкретное сообщество
    Route::post('/create_community', 'create_community')->name('create_community')->middleware('auth');
    Route::get('/messages_community/{title}', 'messages_community')->middleware('auth'); // Для Ajax получения cообщений
    Route::post('/send_community', 'send_community')->middleware('auth'); //Для отправки сообщения
    Route::post('/change_data_community', 'change_data_community')->name('change_data_community')->middleware('auth'); // смена данных сообщества
    Route::post('/change_data_community_addUser', 'change_data_community_addUser')->name('change_data_community_addUser')->middleware('auth'); // добавление пользователя
    Route::post('/change_data_community', 'change_data_community')->name('change_data_community')->middleware('auth'); // Удаление сообщества
    Route::post('/del_community', 'del_community')->name('del_community')->middleware('auth'); // Выход из сообщества
    Route::post('/exit_community', 'exit_community')->name('exit_community')->middleware('auth'); // Выход из сообщества
    
});

Route::controller(indexController::class)->group(function () {
    Route::get('/', 'index')->name('index'); // Страница авторизации
    Route::get('/register', 'register')->name('register'); // Страница регистрации

    Route::post('auth_form', 'auth_form')->name('auth_form'); // Форма авторизация
    Route::post('register_form', 'register_form')->name('register_form'); // Форма регистрации
});

Route::controller(UserController::class)->group(function () {
    Route::get('/account/{username}', 'account')->middleware('auth'); // Профиль
    Route::get('/admin/{username}', 'account')->middleware('auth'); // Профиль администратора
    Route::get('/chats', 'chats')->middleware('auth'); // чаты
    Route::get('/friends/{id}', 'friends')->middleware('auth'); // друзья
    Route::post('/filter_friends', "filter_friends")->name("filter_friends")->middleware("auth");
    Route::post('/filter_my_friends', "filter_my_friends")->name("filter_my_friends")->middleware("auth");
    Route::post('/change_my_data', "change_my_data")->name("change_my_data")->middleware("auth"); // Изменения пользовательских данных
    Route::post('/add_my_photo', "add_my_photo")->name("add_my_photo")->middleware("auth"); // Добавление новой фотографии
    Route::get('/delete_photo/{id}', 'delete_photo')->middleware('auth'); // Удаление фото

    Route::post('/search', 'search')->name('search')->middleware('auth'); // Удаление фото
    Route::get('account_friend/{id}', 'account_friend')->name('account_friend')->middleware('auth'); // Удаление фото
    Route::post('/add_friends', "add_friends")->name("add_friends")->middleware("auth"); // Добавление друга
    Route::post('/del_friends', "del_friends")->name("del_friends")->middleware("auth"); // Удаление друга
    Route::post('/update_friends', "update_friends")->name("update_friends")->middleware("auth"); // Принятие друга
    Route::post('/cancel_friends', "cancel_friends")->name("cancel_friends")->middleware("auth"); // Отклонение друга

    Route::post('/blocked', "blocked")->name("blocked")->middleware("auth"); // Блокировка пользователя
    Route::post('/not_blocked', "not_blocked")->name("not_blocked")->middleware("auth"); // Разблокировка пользователя

    Route::get('/blocked_page_user', 'blocked_page_user')->name('blocked_page_user')->middleware('auth'); // Страница заблокированного пользователя

    Route::post('/resetPassword', "resetPassword")->name("resetPassword"); // Смена пароля

    Route::post('/password_accepted', "password_accepted")->name("password_accepted"); // Подтверждение смены пароля

});
Route::post('/blacklist', [BlacklistController::class, 'blacklist'])->name('blacklist')->middleware('auth'); // Добавить в ЧС
Route::post('/unblacklist', [BlacklistController::class, 'unblacklist'])->name('unblacklist')->middleware('auth'); // Удалить из ЧС

Route::get('/logout', function(){
    $data = Auth::user()->id;
    $user = User::find($data);
    $user->is_service = 'offline';
    $user->save();
    Auth::logout();
    return redirect(route('index'));
})->name('logout'); // Выход
