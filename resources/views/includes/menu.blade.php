<div class="menu_block">
    <div class="container_12">
        <div class="grid_12">
            <nav class="horizontal-nav full-width horizontalNav-notprocessed">
                <ul class="sf-menu">
                    <li><a href="{{ route('homepage') }}">Anasayfa</a></li>
                </ul>                
                <div class="dropdown">
                    <button class="dropbtn"><i class="fa fa-user-circle" aria-hidden="true"></i></button>
                    <div class="dropdown-content">
                        @if (Auth::guest())                        
                            <a href="{{ route('login') }}">Giriş yap</a>
                            <a  href="{{ route('register') }}">Üye ol</a>
                        @else                                                
                            <a href="{{ route('dashboard') }}">Üye paneli</a>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                Çıkış yap
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>