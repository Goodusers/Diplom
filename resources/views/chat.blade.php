@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', 'Чаты' . ' || ' . Auth::user()->token)
@section('content')
<div class="chat_content">
    <div class="chat_block">
        <div class="account-content">
            <div class="chat_profile" id="data-user" data-user-id="{{ Auth::user()->id }}">
                <div class="wrap_profile" id="links-chat" friend-user-id="{{ $user->id }}">
                    <div class="image_chat_friend" id="image_chat_friend" chat-id="{{ $user->my_chats_id}}">
                        <img src="{{asset('/image/userimage'.'/'.$user->photo)}}" alt="user">
                    </div>
                    <div class="buddy_name">
                        <span><a href="{{url('/account_friend'.'/'.$user->id)}}">{{$user->username}}</a></span>
                        @if($user->is_service == 'online')
                            <div class="wrap-color">
                                <p>В сети </p>
                                <div class="color"></div>
                            </div>  
                        @else
                            <div class="wrap-color">
                                <p>Не в сети </p>
                                <div class="red-color"></div>
                            </div>  
                        @endif
                    </div>
                </div>
                <div class="settings_block">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 48 48" xml:space="preserve">
                    <circle style="fill:none;stroke:#252ed0;stroke-width:2;stroke-miterlimit:10;" cx="24" cy="24" r="6.5"/>
                    <path style="fill:none;stroke:#252ed0;stroke-width:2;stroke-linejoin:round;stroke-miterlimit:10;" d="M28.527,39.098
                        c0.156-1.425,0.982-2.69,2.223-3.407s2.75-0.799,4.062-0.222l2.668,1.174c1.921-2.048,3.39-4.523,4.224-7.28l-2.365-1.734
                        C38.183,26.781,37.5,25.434,37.5,24s0.683-2.781,1.839-3.629l2.365-1.734c-0.834-2.757-2.303-5.232-4.224-7.28l-2.668,1.174
                        c-1.312,0.577-2.821,0.495-4.062-0.222s-2.067-1.982-2.223-3.407l-0.318-2.902C26.855,5.684,25.45,5.5,24,5.5
                        s-2.855,0.184-4.209,0.499l-0.318,2.902c-0.156,1.425-0.982,2.69-2.223,3.407s-2.75,0.799-4.062,0.222l-2.668-1.174
                        c-1.921,2.048-3.39,4.523-4.224,7.28l2.365,1.734C9.817,21.219,10.5,22.566,10.5,24s-0.683,2.781-1.839,3.629l-2.365,1.734
                        c0.834,2.757,2.302,5.232,4.224,7.28l2.668-1.174c1.312-0.577,2.821-0.495,4.062,0.222s2.067,1.982,2.223,3.407l0.318,2.902
                        C21.145,42.316,22.55,42.5,24,42.5s2.855-0.184,4.209-0.499L28.527,39.098z"/>
                    </svg>
                </div>
                <div class="container-settings">
                    <div class="item-settings" id="del-history">Очистить историю</div>
                    @if(count($blocked) == 0)
                        <div class="item-settings" id="blocked">Заблокировать</div>
                    @elseif($blocked[0]->user_id == Auth::user()->id)
                        <form action="{{ url('unblacklist') }}" method="POST"> 
                            @csrf
                            <input type="hidden" id="chats_id" name="chats_id" value={{ $id }}>
                            <button class="item-settings" id="unblocked">Разблокировать</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="accepted-del-history">
                <span>ВЫ ДЕЙСТВИТЕЛЬНО ХОТИТЕ УДАЛИТЬ ИСТОРИЮ???</span>
                <div class="button-accepted-del-history">
                    <form action="{{ url('/del_history') }}" method="POST"> 
                        @csrf
                        <input type="hidden" id="user_id" name="user_id" value={{ Auth::user()->id }}>
                        <input type="hidden" id="frined_id" name="frined_id" value={{$user->id }}>
                        <input type="hidden" id="chat_id" name="chat_id" value={{ $id }}>
                        <button id="next-accepted-del-history">Подтверждаю</button>
                    </form>
                    <button id="close-accepted-del-history">Отменить</button>
                </div>
            </div>
            <div class="accepted-blacklist">
                <span>ВЫ ДЕЙСТВИТЕЛЬНО ХОТИТЕ ЗАБЛОКИРОВАТЬ {{ $user->username }}???</span>
                <div class="button-accepted-blacklist">
                    <form action="{{ url('/blacklist') }}" method="POST"> 
                        @csrf
                        <input type="hidden" id="user_id" name="user_id" value={{ Auth::user()->id }}>
                        <input type="hidden" id="friend_id" name="friend_id" value={{ $id }}>
                        <input type="hidden" id="chat_id" name="chat_id" value={{ $user->id }}>
                        <button id="next-accepted-blacklist">подтверждаю</button>
                    </form>
                    <button id="close-accepted-blacklist">отменить</button>
                </div>
            </div>
            <chat-message></chat-message>
            @if(count($blocked) == 0)
                <chat-form></chat-form>
            @elseif($blocked[0]->user_id == Auth::user()->id)
                <small id="blocked-friend">вы заблокировали пользователя</small>
            @else 
                <small id="blocked-friend">вас добавили в черный список</small>
            @endif
        </div>
    </div>
</div>
@endsection
<script>
    function triggerClickPhotos(){
      document.getElementById('image').click();
    }
</script>