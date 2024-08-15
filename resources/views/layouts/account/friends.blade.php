@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', " Друзья ")

    @section('content')
    <div class="model-access-friend">
        <span>ПОЛЬЗОВАТЕЛЬ ДОБАВЛЕН В ДРУЗЬЯ!</span>
    </div>
    <div class="chat_content">
        <div class="chat_block">

            <div class="account-content">
                <div class="modal-fr">
                    {{-- {{dd($pending)}} --}}
                    @if(count($pending) > 0)
                        @foreach($pending as $item_app)
                        {{-- {{dd($pending)}}   --}}
                                <div class="item-fr-app">
                                    <div id="close_friend-icon" class="close-button">&times;</div>
                                    <a href="{{url('/account_friend'.'/'.$item_app->user_id)}}"><img src="{{asset('image/userimage/'.$item_app->photo)}}" class="app-name app-photo"></a>
                                    <div class="app-name">{{$item_app->username}}</div>
                                    
                                    <form action="{{route('update_friends')}}" method="POST">
                                        @csrf
                                        <input style="display: none" id="add-friend" type="hidden" name="id" value="{{$item_app->id}}">
                                        <button type="submit" id="app-name" class="app-name">ДОБАВИТЬ</button>
                                    </form>
                                    <form action="{{route('del_friends')}}" method="POST">
                                        @csrf
                                        <input style="display: none" id="add-friend" type="hidden" name="id" value="{{$item_app->id}}">
                                        <button type="submit" class="reject-button">ОТКЛОНИТЬ</button>
                                    </form>
                                </div>
                        @endforeach
                    @else
                    <div class="info_appl">
                        <p>у вас нет заявок</p>
                        <button id="close_friend-icon" type="submit">закрыть</button>
                    </div>
        
                    @endif
                </div>

                    <div class="chat_profile friends-list">
                        <div class="links-category-friends">
                            <button id="appl">ЗАЯВКИ</button>
                            {{-- <a href="">Мои друзья</a> --}}
                        </div>
                        <form action="{{ route('filter_friends') }}" method="post" id="all_users" class="links-category-friends">
                            @csrf
                            <input type="hidden" name="all_users" value="1">
                            <button id="appl">ПОЛЬЗОВАТЕЛИ</button>
                        </form>
                        <form action="{{ route('filter_my_friends') }}" method="post" id="my_friends" class="links-category-friends">
                            @csrf
                            <input type="hidden" name="my_friends" value="2">
                            <button id="appl">ДРУЗЬЯ</button>
                        </form>
                        <form action="{{route('search')}}" method="POST" class="search-friends">
                            @csrf
                            <input type="search" name="search" id="search" placeholder="Поиск">
                            <button type="submit"><img src="/image/search-friends/search.png" alt="search"></button>
                        </form>
                    </div>
                @if(Auth::user()->role == 1)
                    @foreach($admin as $friends_all)
                        
                        @if(isset($friends_all))
                            <div class="links-chat">
                                <div class="chat-item friends-item">
                                    <div class="wrap_profile addone-profile">
                                        <div class="image_chat_friend">
                                            <img src="{{asset('/image/userimage'.'/'.$friends_all->photo)}}" alt="user">
                                        </div>
                                        <div class="buddy_name">
                                            <a href="{{url('/account_friend'.'/'.$friends_all->id)}}" class="links-name">{{$friends_all->username}}</a>
                                            <a href="#" class="links-message">написать сообщение</a>
                                            @if($friends_all->is_service == "online")
                                                <div class="wrap-color">
                                                    <p>в сети </p>
                                                    <div class="color"></div>
                                                </div>
                                            @else
                                                <div class="wrap-color">
                                                    <p>не в сети</p>
                                                    <div class="red-color"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                    @endforeach
                @else
                    @foreach($friend as $friends)
                            {{-- {{dd($friends)}} --}}
                        @if(isset($friends))
                            <div class="links-chat">
                                <div class="chat-item friends-item">
                                    <div class="wrap_profile addone-profile">
                                        <div class="image_chat_friend">
                                            <img src="{{asset('/image/userimage'.'/'.$friends->photo)}}" alt="user">
                                        </div>
                                        <div class="buddy_name">
                                            <a href="{{url('/account_friend'.'/'.$friends->id)}}" class="links-name">{{$friends->username}}</a>
                                            @if($friends->my_chats_id)
                                            {{-- {{ dd($friends) }} --}}
                                                <a href="{{url('/chat'.'/'. $friends->my_chats_id)}}" class="links-message">написать сообщение</a>
                                            @endif
                                            @if($friends->is_service == "online")
                                                <div class="wrap-color">
                                                    <p>в сети </p>
                                                    <div class="color"></div>
                                                </div>
                                            @else
                                                <div class="wrap-color">
                                                    <p>не в сети</p>
                                                    <div class="red-color"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="error-friend">НЕТ ИНФОРМАЦИИ</div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>



@endsection
