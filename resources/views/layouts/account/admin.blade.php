@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', Auth::user()->username . ' || ' . Auth::user()->token)

@section('content')

    <div class="account-content">
        <div class="background-template">
            <div class="image-profile-wrap">
                <div class="image-profile"><img src="{{asset('image/userimage/'.$user->photo)}}" alt="{{Auth::user()->photo}}"></div>
            </div>
            <div class="name-user">
                <p id="name-user-name"> {{Auth::user()->username}} </p>
                <span>Город: {{Auth::user()->city}} </span>
                <div class="more-info">
                    <p>Друзей: {{$result}}</p>

                </div>
            </div>
            <div class="actions-account"></div>
            <button id="open-modal-edit" class="button-change-data-user"> редактировать </button>

            <div class="modal-edit">
                <form action="{{route('change_my_data')}}" method="post" class="change-data-user" enctype="multipart/form-data">
                    @csrf
                    <label for="username">Введите имя</label>
                    <input type="text" name="username" id="username" autocomplete="off"  value="{{old('username', Auth::user()->username)}}">
    
                    @error('username')
                        <div class="alertError">{{$message}}</div>
                    @enderror
    
                    <label for="email">Введите email</label>
                    <input type="email" name="email" id="email" autocomplete="off" value="{{old('email', Auth::user()->email)}}">
    
                    @error('email')
                        <div class="alertError">{{$message}}</div>
                    @enderror
    
                    <label for="phone">Введите номер телефона</label>
                    <input type="tel" name="phone" id="phone" autocomplete="off" value="{{old('phone', Auth::user()->phone)}}">
    
                    @error('phone')
                        <div class="alertError">{{$message}}</div>
                    @enderror
    
                    <label for="city">Введите свой город</label>
                    <input type="text" name="city" id="city" autocomplete="off" value="{{old('city', Auth::user()->city)}}">
    
                    @error('city')
                        <div class="alertError">{{$message}}</div>
                    @enderror

                    <label for="token">Введите токен</label>
                    <input type="text" name="token" id="token" autocomplete="off" value="{{old('token', Auth::user()->token)}}">
    
                    @error('token')
                        <div class="alertError">{{$message}}</div>
                    @enderror

                    <label for="photo">Выберите фото</label>
                    <input type="file" name="photo" id="photo" autocomplete="off">
    
                    @error('photo')
                        <div class="alertError">{{$message}}</div>
                    @enderror
    
                    <button type="submit" id="send">ИЗМЕНИТЬ</button>
                    <button type='submit' id="background">СМЕНИТЬ ФОН</button>
                </form>
                <button class="exit-button"><svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                </svg></button>
            </div>
    
        </div>
        <div class="photo-profile">
            <div class="photo-profile-image" >
                <button id="button-open-window-add-photo">  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="200px" height="200px" viewBox="0 0 32 32" enable-background="new 0 0 32 32" xml:space="preserve">
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
                    <button type="submit" id="send-photo">ЗАГРУЗИТЬ</button>
                </form>
                <button class="exit-add-photo"><svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                </svg></button>
            </div>
            @foreach ($photo as $item)
                {{-- {{dd($item->photos_id)}} --}}
                @if($item)
                    <div id="ph" class="photo-profile-image">
                        <a class="delete-photo" href="{{url('/delete_photo'.'/'.$item->photos_id)}}"><svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                        </svg></a>
                        <img  src="{{asset('/image/userimage/'.$item->photo)}}" alt="my-photo">
                    </div>
                
                @else
                   <div class="photo-profile-image"> НЕТ ФОТОГРАФИЙ</div> 
                @endif
            @endforeach


        </div>
    </div>
@endsection
