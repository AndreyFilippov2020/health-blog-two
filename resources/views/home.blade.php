<?php
/** @var $posts  \Illuminate\Pagination\LengthAwarePaginator */

?>

<x-app-layout meta-title="My Blog" meta-description="Lorem ipsum dolor sit amet, consectetur adipisicing elit">
<section class="w-full md:w-2/3 flex flex-col items-center px-3">

@foreach($posts as $post)
    <x-post-item :post="$post"></x-post-item>
@endforeach


    <!-- Pagination -->
    <div class="flex items-center py-8">
        {{ $posts->onEachSide(1)->links() }}
    </div>

</section>
<x-sidebar></x-sidebar>
</x-app-layout>
