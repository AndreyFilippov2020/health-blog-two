<x-app-layout :meta-title="$post->meta_title ?: $post->title" :meta-description="$post->meta_description">
    <section class="w-full xl:w-2/3 flex flex-col px-3">

        <article class="flex flex-col my-4">
            <!-- Article Image -->
            <div class="flex justify-center max-h-max overflow-hidden">
                <img src="{{ $post->getThumbnail() }}" class="w-auto object-contain ">
            </div>
            <div class="flex flex-col justify-start py-6">
                <div class="flex gap-3 flex-wrap">
                    @foreach($post->categories as $category)
                        <a href="{{route('by-category', $category)}}" class="text-blue-500/80 text-sm font-bold uppercase pb-4">{{ $category->title }}</a>
                    @endforeach
                </div>
                <h1 class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</h1>
                <p class="text-sm pb-8">
                    By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published
                    on {{ $post->getFormatedDate() }} | {{ $post->human_read_time }}
                </p>
                <div> {!! $post->body !!}</div>
                <livewire:upvote-downvote :post="$post"/>
            </div>
        </article>



        <div class="w-full flex pt-6">
            <div class="w-1/2">
                @if($prev)
                    <a href="{{ route('view', $prev) }}"
                       class="block w-full  bg-white shadow hover:shadow-md text-left p-6 max-h-40 h-full">
                        <p class="text-lg text-blue-800 font-bold flex items-center"><i
                                class="fas fa-arrow-left pr-1"></i>
                            Previous</p>
                        <p class="pt-2">{{ \Illuminate\Support\Str::words($prev->title, 10) }}</p>
                    </a>
                @endif
            </div>
            <div class="w-1/2">
                @if($next)
                    <a href="{{ route('view', $next) }}"
                       class="block w-full  bg-white shadow hover:shadow-md text-right p-6 max-h-40 h-full">
                        <p class="text-lg text-blue-800 font-bold flex items-center justify-end">Next <i
                                class="fas fa-arrow-right pl-1"></i></p>
                        <p class="pt-2">{{ \Illuminate\Support\Str::words($next->title, 10) }}</p>
                    </a>
                @endif
            </div>
        </div>

        <livewire:comments :post="$post"/>
    </section>
    <x-sidebar></x-sidebar>
</x-app-layout>
