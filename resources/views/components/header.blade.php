<header class="bg-gray-900 text-white">
    <div class="header-content flex justify-between items-center px-4 py-2">
        <!-- Left side of the header -->
        <div>
            <!-- Your logo or title can go here -->
            <h1 class="text-xl font-bold tracking-wider text-green-400">Media<span class="text-white">Base</span></h1>
        </div>
        
        <!-- Right side of the header -->
        <ul class="flex gap-4">
            @if(Auth::check())
                <li class="login">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded focus:outline-none">Logout</button>
                    </form>
                </li>
            @else
                <li class="login">
                    <a href="{{ route('login') }}" class="text-white hover:text-green-300">Login</a>
                </li>
            @endif
        </ul>
    </div>
</header>
