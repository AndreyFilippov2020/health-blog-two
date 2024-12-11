<x-app-layout meta-title="Copper Wellness - About us">

    <div class="xl:container mx-auto py-6">

        <!-- Post Section -->
        <section class="w-full px-3">

            <article class="flex flex-col shadow my-4">
                @if($widget && $widget->image)
                    <img src="/storage/{{ $widget->image }}">
                @endif

                <div class="bg-white p-6">
                    <h1 class="text-3xl font-bold hover:text-gray-700 pb-4">
                        {{$widget ? $widget->title : ''}}
                    </h1>
                    <div>
                        {!! $widget ? $widget->content : '' !!}
                    </div>
                </div>
            </article>
        </section>

    </div>
</x-app-layout>
