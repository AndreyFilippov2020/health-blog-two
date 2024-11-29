<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $metaTitle ?: 'My Blog' }}</title>
    <meta name="author" content="Andrey Filippov">
    <meta name="description" content="{{ $metaDescription }}">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
    </style>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
            integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-family-karla">


<!-- Text Header -->
<header class="w-full xl:container mx-auto sticky top-0 bg-gray-50">
    <div class="flex flex-col items-center pb-5 pt-10">
        <a class="font-bold text-gray-800 uppercase hover:text-gray-700 text-5xl" href="{{route('home')}}">
            {{ \App\Models\TextWidget::getTitle('header') }}
        </a>
        <p class="text-lg text-gray-600">
            {!!  \App\Models\TextWidget::getContent('header') !!}
        </p>
    </div>
</header>

<!-- Topic Nav -->
<nav class="w-full border-t border-b bg-white sticky top-[132px] shadow" x-data="{ open: false }" >
    <div class="block xl:hidden cursor-pointer">
        <div
    class="block xl:hidden text-base font-bold uppercase text-center flex justify-end items-center pr-6 py-4"
            @click="open = !open"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>

{{--            Topics <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="fas ml-2"></i>--}}
        </div>
    </div>
    <div :class="open ? 'block': 'hidden'" class="w-full flex-grow items-end flex-col xl:flex xl:items-start xl:w-auto">
        <div
            class="w-full xl:container mx-auto flex flex-col xl:flex-row items-end justify-between text-sm font-bold uppercase mt-0 px-6 py-2">
            <div class=" flex flex-col xl:flex-row items-end justify-between text-sm">
                <a href="{{route('home')}}" class="xl:hover:bg-theme-color xl:hover:text-white rounded py-4 xl:py-2 xl:px-4 xl:mx-2">Home</a>
                <x-dropdown>
                    <x-slot name="trigger">
                        <button
                            class="font-bold uppercase inline-flex items-center xl:px-3 py-4 xl:py-2 border border-transparent text-sm leading-4 rounded-md  xl:hover:bg-theme-color xl:hover:text-white xl:dark:hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div>Categories</div>

                            <div class="ms-1 xl:block hidden">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @foreach($categories as $category)
                            <a href="{{route('by-category', $category)}}"
                               class="xl:hover:bg-gray-200/20  text-white xl:dark:hover:text-white inline-block w-full py-3 xl:py-2 pl-2" >{{$category->title}}</a>
                        @endforeach
                    </x-slot>

                </x-dropdown>

                <a href="{{route('about-us')}}" class="xl:hover:bg-theme-color xl:hover:text-white rounded py-4 xl:py-2 xl:px-4 xl:mx-2">About
                    us</a>
            </div>

            <div class="flex items-end xl:items-center flex-col xl:flex-row w-full xl:w-auto py-4 xl:py-0">
                <form method="get" action="{{route('search')}}" class="w-full">
                    <input name="q" value="{{request()->get('q')}}"
                           class="block w-full xl:w-auto rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-theme-color sm:text-sm sm:leading-6 font-medium"
                           placeholder="Type an hit enter to search anything"/>
                </form>
                @auth
                    <div class="flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="xl:hover:bg-theme-color xl:hover:text-white flex items-center rounded py-2 xl:px-4 xl:mx-2">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{route('login')}}"
                       class="hover:bg-theme-color hover:text-white rounded py-2 px-4 mx-2">Login</a>
                    <a href="{{route('register')}}" class="bg-theme-color text-white rounded py-2 px-4 mx-2">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<div class="xl:container mx-auto py-6 xl:px-6 flex">

    {{ $slot }}

</div>

<footer class="w-full border-t bg-white pb-12">
    <div class="w-full container mx-auto flex flex-col items-center">
        <div class="uppercase py-6">&copy; myblog.com</div>
    </div>
</footer>

@livewireScripts
</body>
</html>
