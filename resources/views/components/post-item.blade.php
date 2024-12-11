<article class="flex flex-col  bg-white shadow my-4">
    <!-- Article Image -->
    <a href="{{ route('view', $post) }}" class="bg-white">
        <img src="{{ $post->getThumbnail() }}" class="">
    </a>
    <div class="bg-white flex flex-col justify-start p-6">
      <div class="flex gap-3 flex-wrap">
          @foreach($post->categories as $category)
              <a href="{{route('by-category', $category)}}" class="text-blue-500/80 text-sm font-bold uppercase pb-4">{{ $category->title }}</a>

          @endforeach
      </div>


        <a href="{{ route('view', $post) }}" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</a>
        <p href="#" class="text-sm pb-3">
             Опубликовано
{{--            <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>--}}
            {{ $post->getFormatedDate() }} | {{ $post->human_read_time }}
        </p>
        <a href="{{ route('view', $post) }}" class="pb-6">{{ $post->shortBody() }}</a>
        <a href="{{ route('view', $post) }}" class="uppercase text-gray-800 hover:text-black">Подробнее <i class="fas fa-arrow-right"></i></a>
    </div>
</article>
