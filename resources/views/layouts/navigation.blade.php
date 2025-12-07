<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <a href="{{ route('home') }}" class="flex items-center text-lg font-bold">
                    My Store
                </a>

            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600">Logout</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="ml-4 text-blue-600">Login</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
