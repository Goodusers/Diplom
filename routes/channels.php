<?php

use App\Broadcasting\ChatChannel;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;


Broadcast::channel('chat.{chat_id}', function($user, $chat_id){
    return Auth()->check();
});

Broadcast::channel('community_page.{title}', function($user, $title){
    return Auth()->check();
});
