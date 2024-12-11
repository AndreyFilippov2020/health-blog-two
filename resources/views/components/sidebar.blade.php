<!-- Sidebar Section -->
<aside class="w-full hidden xl:w-1/3 xl:flex flex-col items-center px-3">
    <div class="w-full bg-white border-2 border-theme-color shadow flex flex-col my-4 p-6">
        <h3 class="text-xl font-semibold mb-3">Все категории
        </h3>
        @foreach($categories as $category)
            <a href="{{ route('by-category', $category) }}"
               class="text-semibold block py-2 px-3 rounded {{ request('category')?->slug === $category->slug
                ? 'bg-theme-color text-white' :  ''}}">
                {{$category->title}} ({{$category->total}})
            </a>
        @endforeach
    </div>
    <div class="w-full bg-white border-2 border-theme-color shadow flex flex-col my-4 p-6">
        <p class="text-xl font-semibold pb-5"> {{ \App\Models\TextWidget::getTitle('about-us-sidebar') }}</p>
        <p class="pb-2">{!! \App\Models\TextWidget::getContent('about-us-sidebar') !!}</p>
        <a href="{{ route('about-us') }}"
           class="w-full bg-theme-color text-white font-bold text-sm uppercase rounded hover:bg-theme-color/50 flex items-center justify-center px-2 py-3 mt-4">
            Подробнее
        </a>
    </div>

</aside>
