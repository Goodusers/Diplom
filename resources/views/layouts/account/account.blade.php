@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', Auth::user()->username . ' || ' . Auth::user()->token)

@section('content')
    <div class="account-content">
        <div class="background-template">
            <div class="image-profile-wrap">
                <div class="image-profile"><img src="{{asset('image/userimage/'.$user->photo)}}" alt="{{Auth::user()->photo}}" id="img_user"></div>
            </div>
            <div class="name-user">
                <p id="name-user-name"> {{Auth::user()->username}} </p>
                <span id="user-city">Город: {{Auth::user()->city}} </span>
                <span id="user-city">Токен поиска: {{Auth::user()->token}} </span>
                <div class="more-info">
                    <p>Друзей: {{$result}}</p>
                </div>
            </div>
            <div class="actions-account"></div>
            <button id="open-modal-edit" class="button-change-data-user"> Редактировать </button>

            <div class="acc_friend">
                @if(count($app) > 0)
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
                @else
                    <div class="no_data">Нет данных</div>
                @endif
            </div>

            <div class="modal-edit">
                <form action="{{route('change_my_data')}}" method="post" class="change-data-user" enctype="multipart/form-data">
                    @csrf
                    <label for="username">Введите имя</label>
                    <input type="text" name="username" id="username" autocomplete="off"  value="{{old('username', Auth::user()->username)}}">
    
                    <label for="email">Введите email</label>
                    <input type="email" name="email" id="email" autocomplete="off" value="{{old('email', Auth::user()->email)}}">
    
                    <label for="phone">Введите номер телефона</label>
                    <input type="tel" name="phone" id="phone" autocomplete="off" value="{{old('phone', Auth::user()->phone)}}">
    
                    <label for="city">Введите свой город</label>
                    <input type="text" name="city" id="city" autocomplete="off" value="{{old('city', Auth::user()->city)}}">

                    <label for="token">Введите токен</label>
                    <input type="text" name="token" id="token" autocomplete="off" value="{{old('token', Auth::user()->token)}}">

                    <label for="photo">Выберите фото</label>
                    <input type="file" name="photo" id="photo" autocomplete="off" >
    
                    <button type="submit" id="send">Изменить</button>
                </form>
                <button class="exit-button"><svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                </svg></button>
            </div>
    
        </div>
        <div class="photo-profile">
            <div class="photo-profile-image" >
                <button id="button-open-window-add-photo">  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="150px" height="150px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" xml:space="preserve">
                <g>
                    <path fill="#808184" d="M23.5,16H17V8.5C17,8.224,16.776,8,16.5,8S16,8.224,16,8.5V16H8.5C8.224,16,8,16.224,8,16.5
                        S8.224,17,8.5,17H16v6.5c0,0.276,0.224,0.5,0.5,0.5s0.5-0.224,0.5-0.5V17h6.5c0.276,0,0.5-0.224,0.5-0.5S23.776,16,23.5,16z"/>
                </g>
                </svg> </button>
            </div>
            <div class="add_photo">
                <form action="{{route('add_my_photo')}}" method="post" class="add-data-user-photo">
                    @csrf;
                    <input type="file" name="file">
                    @error('file')
                        <div class="alertError">{{$message}}</div>
                    @enderror
                    <button type="submit" id="send-photo">Загрузить</button>
                </form>
                <button class="exit-add-photo"><svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                </svg></button>
            </div>
            @foreach ($photo as $item)
                @if($item)
                    <div id="ph" class="photo-profile-image">
                        <a class="delete-photo" href="{{url('/delete_photo'.'/'.$item->photos_id)}}"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg></a>
                        <img  src="{{asset('/image/userimage/'.$item->photo)}}" alt="my-photo">
                        <small class="small_photo">{{Carbon\Carbon::parse($item->create)->locale('ru')->isoFormat('D MMMM YYYY')}}</small>

                    </div>
                @else
                   <div class="photo-profile-image"> Нет фотографий</div> 
                @endif
            @endforeach


        </div>
    </div>

@endsection
