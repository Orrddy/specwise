<nav class="bg-white/70 backdrop-blur-xl text-on-surface-variant font-body-md text-body-md sticky top-0 z-50 border-b border-on-surface/5 shadow-sm">
    <div class="flex justify-between items-center px-margin-desktop py-4 max-w-container-max mx-auto">
        <div class="flex items-center gap-8">
            <a class="font-display-lg text-display-lg-mobile md:text-headline-md font-bold text-surface-tint tracking-tight cursor-pointer active:scale-95 transition-transform" href="{{ route('home') }}">SpecWise</a>
            <div class="hidden md:flex gap-6">
                <a class="{{ request()->routeIs('home') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-medium hover:text-primary' }} transition-colors duration-200" href="{{ route('home') }}">Home</a>
                <a class="{{ request()->routeIs('categories.*') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-medium hover:text-primary' }} transition-colors duration-200" href="#">Categories</a>
                @auth
                <a class="{{ request()->routeIs('dashboard') ? 'text-primary font-bold border-b-2 border-primary pb-1' : 'text-on-surface-variant font-medium hover:text-primary' }} transition-colors duration-200" href="{{ route('dashboard') }}">Watchlist</a>
                @endauth
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative hidden lg:block">
                <form action="{{ route('search') }}" method="GET">
                    <input class="bg-surface-container-low border-none rounded-full py-2 px-6 w-64 focus:ring-2 focus:ring-primary/20 transition-all" name="q" placeholder="Search products..." type="text" value="{{ request('q') }}"/>
                </form>
            </div>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="bg-surface-container-low text-on-surface-variant px-6 py-2 rounded-full font-semibold cursor-pointer active:scale-95 transition-transform hover:opacity-90">Sign Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-primary text-white px-6 py-2 rounded-full font-semibold cursor-pointer active:scale-95 transition-transform hover:opacity-90">Sign In</a>
            @endauth
        </div>
    </div>
</nav>
