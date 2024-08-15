@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', $user->username . ' || ' . $user->token)

@section('content')
    @if($user->is_blocked == 0)
    <div class="account-content">
        <div class="background-template">
            <div class="image-profile-wrap">
                <div class="image-profile"><img src="{{asset('image/userimage/'.$user->photo)}}" alt="{{$user->photo}}"></div>
            </div>
            <div class="name-user">
                <p id="name-user-name"> {{$user->username}} </p>
                <span>Город: {{$user->city}} </span>
                <span>Поисковой токен: {{$user->token}} </span>
                <div class="more-info">
                    <p>Друзей: {{$result}}</p>
                </div>
            </div>
            <div class="actions-account"></div>
                @if(Auth::user() -> role == 0 )
                    @foreach($result_merge as $item_res)
                        @if($item_res->status == "pending" )
                            @if($item_res->friend_id == Auth::user()->id )
                                <form action="{{route('del_friends')}}" method="POST" id="variable_accepted">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$friend->main_id}}">
                                    <button type="submit" id="open-modal-edit" class="button-change-data-user"> отклонить </button>
                                </form>
                                <form action="{{route('update_friends')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$item_res->id}}">
                                    <button type="submit" id="open-modal-edit" class="button-change-data-user"> принять </button>
                                </form>
                            @else
                            <form action="{{url('/del_friends')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$friend->main_id}}">
                                <button type="submit" id="open-modal-edit" class="button-change-data-user"> отписаться </button>
                            </form>
                            @endif
                        @elseif($item_res->status == "accepted")
                            <form action="{{route('del_friends')}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{$friend->main_id}}">
                                <button type="submit" id="open-modal-edit" class="button-change-data-user"> удалить из друзей </button>
                            </form>
                        @endif
                    @endforeach
                    @if( count($result_merge) == 0)
                        <form action="{{route('add_friends')}}" method="POST">
                            @csrf
                            <input type="hidden" name="friend_id" value="{{$user->id}}">
                            <button type="submit" id="open-modal-edit" class="button-change-data-user"> добавить в друзья </button>
                        </form>
                    @endif
                @endif
                @if(Auth::user()->role == 1)
                    @if($user->is_blocked == 0)
                        <form action="{{route('blocked')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <button type="submit" id="open-modal-edit" class="button-change-data-user"> Заблокировать </button>
                        </form>
                    @else
                        <form action="{{route('not_blocked')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <button type="submit" id="open-modal-edit" class="button-change-data-user"> Разблокировать </button>
                        </form>
                    @endif
            @endif
            </div>
        <div class="photo-profile">
            @foreach ($photo as $item)
                <div id="ph" class="photo-profile-image">
                    <img  src="{{asset('/image/userimage/'.$item->photo)}}" alt="my-photo">
                    <small class="small_photo">{{Carbon\Carbon::parse($item->create)->locale('ru')->isoFormat('D MMMM YYYY')}}</small>
                </div>
            @endforeach
        </div>
    </div>
    @else
        <div class="account_blocked_users">
            <div class="account_blocked_user">
                <img src="{{ asset('../image/block-user.png') }}" alt="block-user">
                <h1>ПОЛЬЗОВАТЕЛЬ ЗАБЛОКИРОВАН!!!</h1>
                <p>Аккаунт был заблокирован администратором </p> <p>за нарушение правил пользования интернет-ресурсом Pulse</p>
            </div>
            @if(Auth::user()->role == 1)
            <form action="{{route('not_blocked')}}" method="POST" style="margin-top:20px; text-align: center;">
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                <button type="submit" id="open-modal-edit" class="button-change-data-user"> Разблокировать </button>
            </form>
            @endif
        </div>
    @endif
    <div class="acc_friend">
        @if(count($app) > 0 && $app[0]->username != Auth::user()->username)
            @foreach($app as $item)
                @if($item->user_id != Auth::user()->id)
                    <div class="user_block">
                        <div class="photo_user">
                            <img src="{{asset('image/userimage'.'/'.$item->photo)}}" alt="userImage">
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
            {{-- {{dd()}} --}}
        @elseif($app[0]->username == Auth::user()->username)
            <div class="no_data">Только вы</div>
            
        @else
            <div class="no_data">нет данных</div>
        @endif
    </div>
@endsection
