@section('aside')
<aside class="account-asside">
    
    <a href="{{url('/account'.'/'.Auth::user()->username)}}" class="links_item">
        <img id="profile-my-pgoto" src="{{asset('image/userimage/'.Auth::user()->photo)}}" alt="profile">
        <p>{{ Auth::user()->username }}</p>
    </a>
    <a href="{{url('/community')}}" class="links_item">
        <img src="/image/aside-account/happy.png" alt="community">
        <p>Сообщества</p>
    </a>
    <a href="{{url('/chats')}}" class="links_item">
        <img src="/image/aside-account/messenger.png" alt="message">
        <p>Сообщения</p>
    </a>
    <a href="{{url('/friends'. '/' . Auth::user()->id)}}" class="links_item">
        <img src="/image/aside-account/friends.png" alt="friends">
        <p>Друзья</p>
    </a>
    <a href="{{route('logout')}}" class="links_item">
        <img src="/image/aside-account/settings-icon-aside.png" alt="setting-icon">
        <p>Выход</p>
    </a>
</aside>
@endsection
