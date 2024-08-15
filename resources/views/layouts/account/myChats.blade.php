@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', 'Чаты' . ' || ' . Auth::user()->token)

@section('content')
<div class="chat_content">
    <div class="chat_block">
        <div class="account-content">
            <div class="chat_profile">
                <div class="wrap_profile">
                    <span class='text-my-chats'>Чаты</span>
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
            </div>
            @if(isset($not_users) || count($user) == 0)
                <div class="account_blocked_user">
                <h1>Нет чатов</h1>
                </div>
            @else
                @foreach($user as $users)
                    @if($users->username != Auth::user()->username)
                        <a href="{{url('/chat/'. $users->chat_id)}}" class="links-chat">
                            <div class="chat-item">
                                <div class="wrap_profile addone-profile">
                                    <div class="image_chat_friend">
                                        <img src="{{asset('image/userimage/'.$users->photo)}}" alt="{{Auth::user()->photo}}">
                                    </div>
                                    <div class="buddy_name">
                                        <span>{{$users->username}}</span>
                                        @if($users->is_service == 'online')
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
                                    <div class="last-message">
                                        @if($users->user_id == Auth::user()->id)
                                            <span>Вы: {{ $users->message }}</span>
                                            <p>Дата отправки: {{Carbon\Carbon::parse($users->created_at)->format('H:i')}}</span>
                                        @else
                                            <span>{{ $users->message }}</span>
                                            <p>Дата отправки: {{Carbon\Carbon::parse($users->created_at)->format('H:i')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

