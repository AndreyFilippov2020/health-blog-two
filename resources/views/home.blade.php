<?php
/** @var $posts  \Illuminate\Pagination\LengthAwarePaginator */
?>

<x-app-layout meta-title="Copper Wellness" meta-description="Единственный русскоязычный сайт, посвящен обзору «Медного протокола» от Джейсона Гоммеля. Здесь Вы найдете общую информацию, протоколы и рекомендации.">
    <div class="container  mx-auto py-6 px-4 md:px-0">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <!-- Latest Post -->
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-theme-color uppercase pb-1 border-b-2 border-theme-color mb-3">
                    Последняя публикация
                </h2>

                @if ($latestPost)
                    <x-post-item-flex :post="$latestPost"/>
                @endif
            </div>

            <!-- Popular 3 post -->
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-theme-color uppercase pb-1 border-b-2 border-theme-color mb-3">
                    Популярное
                </h2>
                @foreach($popularPosts as $post)
                    <div class="grid grid-cols-4 gap-2 mb-4">
                        <a href="{{route('view', $post)}}" class="pt-1">
{{--                            <pre><?php dd($post) ?></pre>--}}
                            <img src="{{$post->getThumbnail()}}" alt="{{$post->title}}"/>
                        </a>
                        <div class="col-span-3">
                            <a href="{{route('view', $post)}}">
                                <h3 class="text-sm uppercase whitespace-nowrap truncate">{{$post->title}}</h3>
                            </a>
                            <div class="flex gap-4 mb-2">
                                @foreach($post->categories as $category)
                                    <a href="{{route('by-category', $category)}}" class="bg-blue-500/80 text-white p-1 rounded text-xs font-bold uppercase">
                                        {{$category->title}}
                                    </a>
                                @endforeach
                            </div>
                            <div class="text-xs">
                                {{$post->shortBody(10)}}
                            </div>
                            <a href="{{route('view', $post)}}" class="text-xs uppercase text-gray-800 hover:text-black">Подробнее<i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recommended posts -->
        @if($recommendedPosts && count($recommendedPosts) > 0 )
            <div class="mb-8">
                <h2 class="text-lg sm:text-xl font-bold text-theme-color uppercase pb-1 border-b-2 border-theme-color mb-3">
                    Рекомендованое
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    @foreach($recommendedPosts as $post)
                        <x-post-item :post="$post" :show-author="false"/>
                    @endforeach
                </div>
            </div>
        @endif


        <!-- Latest Categories -->

        @foreach($categories as $category)
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-theme-color uppercase pb-1 border-b-2 border-theme-color mb-3">
                    Категория "{{$category->title}}"
                    <a href="{{route('by-category', $category)}}">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </h2>

                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        @foreach($category->publishedPosts()->limit(3)->get() as $post)
                            <x-post-item :post="$post" :show-author="false"/>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>
