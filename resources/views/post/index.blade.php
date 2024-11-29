<x-app-layout :meta-title="'My Blog - ' . $category->title"
              :meta-description="'Posts filtered by category ' . $category->title">
    <div class="container mx-auto flex flex-wrap py-6">

        <!-- Posts Section -->
        <section class="w-full xl:w-2/3  px-3">
            <div class="">

                @foreach($posts as $post)
                    <x-post-item-flex :post="$post"/>
                @endforeach
            </div>
            {{ $posts->links() }}
        </section>

        <!-- Sidebar Section -->
        <x-sidebar />

    </div>
</x-app-layout>
