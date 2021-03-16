@guest
<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
        <ul class="uk-navbar-nav">
            <li>
                <router-link to="/" ><span uk-icon="home"></span></router-link>
            </li>
            @auth
                <li>
                    <router-link to="/user"><span uk-icon="users"></router-link>
                </li>
            @endauth
        </ul>
    </div>  
    @auth
        <!--<div class="uk-navbar-right">
            <div class="uk-navbar-nav uk-padding-small">
                <button class="uk-button uk-button-text" type="button">
                    {{ Auth::user()->name }}
                </button>
             </div>
            
            <div uk-dropdown="mode: click">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Выйти
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </div>
        </div>-->
    @endauth
</nav>
@endguest


