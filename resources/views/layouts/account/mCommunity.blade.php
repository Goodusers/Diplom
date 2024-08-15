@extends('layouts.app')
@extends('layouts.aside.aside')
@section('title', 'Чаты' . ' || ' . Auth::user()->token)

@section('content')
<div class="chat_content">
    <div class="chat_block">

        <div class="account-content">

            <div class="chat_profile">
                <div class="wrap_profile">
                    <span class='text-my-chats'>Сообщества</span>
                </div>
                @if(count($friends) > 0)
                    <div class="settings_block">
                        <button id="button_addCommunity">
                            <svg width="60px" height="60px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                <title>Создать сообщество</title>
                                <desc>Created with Sketch Beta.</desc>
                                <defs></defs>
                                <g id="Page-1" stroke="#98FB98" stroke-width="1" fill="#98FB98" fill-rule="evenodd" sketch:type="MSPage">
                                    <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-464.000000, -1087.000000)" fill="#000000">
                                        <path d="M480,1117 C472.268,1117 466,1110.73 466,1103 C466,1095.27 472.268,1089 480,1089 C487.732,1089 494,1095.27 494,1103 C494,1110.73 487.732,1117 480,1117 L480,1117 Z M480,1087 C471.163,1087 464,1094.16 464,1103 C464,1111.84 471.163,1119 480,1119 C488.837,1119 496,1111.84 496,1103 C496,1094.16 488.837,1087 480,1087 L480,1087 Z M486,1102 L481,1102 L481,1097 C481,1096.45 480.553,1096 480,1096 C479.447,1096 479,1096.45 479,1097 L479,1102 L474,1102 C473.447,1102 473,1102.45 473,1103 C473,1103.55 473.447,1104 474,1104 L479,1104 L479,1109 C479,1109.55 479.447,1110 480,1110 C480.553,1110 481,1109.55 481,1109 L481,1104 L486,1104 C486.553,1104 487,1103.55 487,1103 C487,1102.45 486.553,1102 486,1102 L486,1102 Z" id="plus-circle" sketch:type="MSShapeGroup"></path>
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            <div class="modal-window-add-community">
                <button class="exit-add-community"><svg fill="#EB4C42" width="30px" height="30px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18.8,16l5.5-5.5c0.8-0.8,0.8-2,0-2.8l0,0C24,7.3,23.5,7,23,7c-0.5,0-1,0.2-1.4,0.6L16,13.2l-5.5-5.5  c-0.8-0.8-2.1-0.8-2.8,0C7.3,8,7,8.5,7,9.1s0.2,1,0.6,1.4l5.5,5.5l-5.5,5.5C7.3,21.9,7,22.4,7,23c0,0.5,0.2,1,0.6,1.4  C8,24.8,8.5,25,9,25c0.5,0,1-0.2,1.4-0.6l5.5-5.5l5.5,5.5c0.8,0.8,2.1,0.8,2.8,0c0.8-0.8,0.8-2.1,0-2.8L18.8,16z"/>
                </svg></button>
                <form action="{{ route('create_community') }}" method="post" id="add_community">
                    @csrf
                    <div class="wrapping_title_and_photo">
                        <input type="hidden" name="author_id" style="display: none" value="{{ Auth::user()->id }}">
                        <input type="text" name="name" id="name" placeholder="название...">
                        <svg onclick="photo()" width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="24" fill="white"/>
                            <path d="M5 12V18C5 18.5523 5.44772 19 6 19H18C18.5523 19 19 18.5523 19 18V12" stroke="#CC8899" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 3L12 15M12 15L16 11M12 15L8 11" stroke="#CC8899" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <input type="file" name="photo" id="photo" style="display: none">
                    <select name="user_id[]" id="community_select" multiple>
                        @foreach($friends as $item)
                            <option value="{{ $item->id }}">{{ $item->username }} - {{ $item->token }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="alertError">{{$message}}</div>
                    @enderror
                    <button>Продолжить</button>
                </form>
            </div>
            @if(count($community) > 0 )
                @foreach($community as $item)
                    <a href="{{url('/community_page'.'/'.$item->title)}}" class="links-chat">
                        <div class="chat-item">
                            <div class="wrap_profile addone-profile">
                                <div class="image_chat_friend">
                                    <img src="{{asset('image/community/'.$item->photo)}}" alt="CPhoto">
                                </div>
                                <div class="title">
                                    <p>{{ $item->name }}</p>
                                </div>
                                    {{-- <div class="last-message">
                                        @if($users->user_id == Auth::user()->id)
                                            <span>Вы: {{ $users->message }}</span>
                                            <p>Дата отправки: {{Carbon\Carbon::parse($users->created_at)->format('H:i')}}</span>
                                        @else
                                            <span>{{ $users->message }}</span>
                                            <p>Дата отправки: {{Carbon\Carbon::parse($users->created_at)->format('H:i')}}</span>
                                        @endif
                                    </div> --}}
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="error-friend">
                    Нет данных
                </div>
            @endif
        </div>
    </div>
    
</div>

@endsection

<script>
    function photo(){
      document.getElementById('photo').click();
    }
</script>