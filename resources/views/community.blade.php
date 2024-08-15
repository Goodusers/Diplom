@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', $user->name)

@section('content')
<div class="chat_content">
    <div class="chat_block" id="user-name" user-name="{{ $user->username }}">
        <div class="account-content">
            <div class="chat_profile" id="data-user">
                <div class="wrap_profile" id="links-chat">
                    <div class="image_chat_friend" id="image_chat_friend">
                        <img src="{{asset('/image/community'.'/'.$user->photo)}}" alt="user">
                    </div>
                    <div class="title" id="title" title="{{ $user->title }}">
                        <p>{{ $user->name }}</p>
                        <small>участников: {{ $count_people }}</small>
                    </div>
                </div>
                <div class="settings_block" id="settings_block" user-id="{{ Auth::user()->id }}">

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

            </div>
            <div class="container-settings">
                <div class="interface" id="interface">интерфейс</div>
                @if($user->author_id == Auth::user()->id)
                    <div class="del_community" id="del_community">удалить сообщество</div>
                    <div class="add_user" id="add_user">добавить пользователя</div>
                @else
                    <div class="exit_community" id="exit_community">покинуть сообщество</div>
                @endif
            </div>
            <div class="madal_community_interface">
                <button id="exit_interface">
                    <svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                    </svg>
                </button> 
                <form action="{{ url('/change_data_community') }}" method="post" id="add_community">
                    @csrf
                    <div class="wrapping_title_and_photo_c">
                        <input type="hidden" name="title" style="display: none" value="{{ $user->title }}">
                        <input type="text" name="name" id="name" value="{{ $user->name }}">
                        <input type="file" name="photo" id="photo">
                
                    </div>
                    <button type="submit"> продолжить</button>
                </form>
            </div>

            <div class="madal_community_add_user">
                <button id="exit_add_user">
                    <svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                    </svg>
                </button>
                <form action="{{ url('/change_data_community_addUser') }}" method="post" id="add_community">
                    @csrf
                    <div class="wrapping_title_and_photo_c">
                        <input type="hidden" name="title" style="display: none" value="{{ $user->title }}">
                        <input type="hidden" name="author_id" style="display: none" value="{{ $user->author_id }}">
                        <input type="hidden" name="photo" style="display: none" value="{{ $user->photo }}">
                        <input type="hidden" name="name" style="display: none" value="{{ $user->name }}">
                        <select name="user_id[]" id="community_select" multiple>
                            @foreach($friends as $item)
                                @if($item->user_id != Auth::user()->id)
                                    <option value="{{ $item->user_id }}">{{ $item->username }} - {{ $item->token }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"> продолжить</button>
                </form>
            </div>
            <div class="madal_community_del">
                <button id="exit_del">
                    <svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                    </svg>
                </button>
                <span>УДАЛИТЬ СООБЩЕСТВО???</span>
                <div class="button-accepted-del-history">
                    <form action="{{ url('/del_community') }}" method="POST"> 
                        @csrf
                        <input type="hidden" id="id" name="id" value={{ $user->title}}>
                        <button type="submit" id="next-accepted-del-comm">подтверждаю</button>
                    </form>
                    <button id="close-accepted-del-history-comm">отменить</button>
                </div>
            </div>
            <div class="madal_community_exit">
                <button id="exit_exit">
                    <svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                    </svg>
                </button>
                <span>ПОКИНУТЬ СООБЩЕСТВО???</span>
                <div class="button-accepted-del-history">
                    <form action="{{ url('/exit_community') }}" method="POST"> 
                        @csrf
                        <input type="hidden" id="id_comm" name="id_comm" value={{ $user->title}}>
                        <button type="submit" id="next-accepted-del-exit">подтверждаю</button>
                    </form>
                    <button id="close-accepted-del-history-exit">отменить</button>
                </div>
            </div>

            <message-community></message-community>
            <form-community></form-community>
        </div>
    </div>
</div>
    <div class="uchastniki">
        <div class="insaide_block">
            @foreach($users_community as $item)
                @if($item->user_id != Auth::user()->id)
                    <div class="user_block">
                        <div class="photo_user">
                            <img src="{{asset('image/userimage'.'/'.$item->user_photo)}}" alt="userImage">
                        </div>
                        <a href="{{url('/account_friend'.'/'.$item->user_id)}}" class="name_user">{{ $item->username }}</a>
                        @if($item->is_service == 'online')
                        <div class="wrap-color">
                            <div class="color"></div>
                        </div>  
                        @else
                            <div class="wrap-color">
                                <div class="red-color"></div>
                            </div>  
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

