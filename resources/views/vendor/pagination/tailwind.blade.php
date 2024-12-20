@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-theme-color border border-theme-color cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-theme-color dark:border-theme-color">
                {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-theme-color border border-theme-color leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-theme-color active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-theme-color dark:border-theme-color dark:text-gray-300 dark:focus:border-theme-color dark:active:bg-gray-700 dark:active:text-gray-300">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-theme-color border border-theme-color leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-theme-color active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-theme-color dark:border-theme-color dark:text-gray-300 dark:focus:border-theme-color dark:active:bg-gray-700 dark:active:text-gray-300">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-theme-color border border-theme-color cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-theme-color dark:border-theme-color">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>


        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">


            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse ">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">

{{--                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">--}}
{{--                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />--}}
{{--                                </svg>--}}
{{--                            </span>--}}
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="h-10 w-10 font-semibold text-gray-500 hover:text-gray-900 text-sm flex items-center justify-center mr-3">
                           <i class="fas fa-arrow-left mr-2"></i>
                              Prev
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="h-10 w-10 bg-theme-color hover:bg-theme-color/50 font-semibold text-white text-sm flex items-center justify-center">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="h-10 w-10 font-semibold text-gray-800  hover:bg-theme-color/50 hover:text-white text-sm flex items-center justify-center">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="h-10 w-10 font-semibold text-gray-500 hover:text-gray-900 text-sm flex items-center justify-center ml-3">
                            Next
                        <i class="fas fa-arrow-right ml-2"></i>
                        </a>
{{--                    @else--}}
{{--                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">--}}
{{--                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">--}}
{{--                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />--}}
{{--                                </svg>--}}
{{--                            </span>--}}
{{--                        </span>--}}
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
