<article class="xl:flex justify-between bg-white shadow my-4 ">
    <!-- Article Image -->
    <a href="{{ route('view', $post) }}"
       class="bg-white xl:w-1/3 shrink-0 items-start w-full block"
       style="height: 322px;  overflow: hidden">
        <img src="{{ $post->getThumbnail() }}" style="width: 100%; height: 100%; object-fit: cover" alt="">
    </a>
    <div class="bg-white w-full flex flex-col justify-start p-6 xl:w-2/3">
        <div class="flex gap-3 flex-wrap">
            @foreach($post->categories as $category)
                <a href="{{route('by-category', $category)}}"
                   class="text-blue-500/80 text-sm font-bold uppercase pb-4">{{ $category->title }}</a>

            @endforeach
        </div>


        <a href="{{ route('view', $post) }}" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</a>
        <p href="#" class="text-sm pb-3">
            By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published
            {{ $post->getFormatedDate() }} | {{ $post->human_read_time }}
        </p>
        <a href="{{ route('view', $post) }}" class="pb-6">{{ $post->shortBody() }}</a>
        <a href="{{ route('view', $post) }}" class="uppercase text-gray-800 hover:text-black">Continue Reading <i
                class="fas fa-arrow-right"></i></a>
    </div>
</article>
