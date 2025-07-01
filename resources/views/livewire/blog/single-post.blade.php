<div class="container grid grid-cols-3 gap-4 py-10 mx-auto">

    <div class="{{$isPagesCat ? 'col-span-3' : 'col-span-2'}} p-4 prose border shadow-lg">
        <header>
            <h1 class="!leading-[45px] h2 mb-0 font-bold !text-transparent bg-gradient-to-r blue-gradient bg-clip-text">{{ $post->title }}</h1>

            <div class="flex items-center justify-between text-sm font-bold">
                <div class="flex flex-col gap-1">
                    <span class="!text-transparent bg-gradient-to-r blue-gradient bg-clip-text">
                        <i class="far fa-calendar-alt"></i>
                        {{ $post->created_at->format('F j, Y') }}
                    </span>
                    <span>
                        <i class="fas fa-eye"></i>
                        {{ $post->stat }} {{ __('views') }}
                    </span>

                </div>
                @if (count($post->categories) > 0 && !in_array('pages', $post->categories->pluck('slug')->toArray()))
                <div class="flex items-center gap-2 mt-4 mb-2">
                    <span class="!text-transparent bg-gradient-to-r blue-gradient bg-clip-text">
                        <i class="fas fa-tags"></i>
                    </span>
                    <span class="flex flex-wrap gap-1">
                        @forelse ($post->categories as $cat)
                        <span>
                            <a class="text-logo-blue" href="{{LaravelLocalization::localizeUrl('/blog/' . $cat->slug)}}">
                                {{ __( $cat->name)}}</a>{{$loop->last ? '' : ', '}}
                        </span>
                        @empty
                        @endforelse
                    </span>
                </div>
                @endif
            </div>
        </header>

        @if ($post->image != null)
        <img class="rounded" src="{{ Storage::url($post->image->path) }}" alt="{{ $post->title }}">
        @endif

        <div>{!! $post->body !!}</div>
    </div>

    @if (!$isPagesCat)
    <div>
        {{-- <div class="sticky top-16"> --}}
            <h4 class="mb-2 text-2xl font-bold h3">{{__('Related Posts')}}</h4>

            @foreach ($related as $post)
            <div class="p-4 mb-3 transition-all duration-300 border border-gray-100 rounded bg-gray-50 hover:bg-gray-100">
                <span class="text-sm">
                    <i class="far fa-calendar-alt"></i>
                    {{ $post->created_at->format('F j, Y') }}
                </span>
                <a class="no-underline hover:!underline" href="{{LaravelLocalization::localizeUrl('/blog/' . $post->id . '/' . $post->slug)}}">
                    <h3 class="text-lg font-bold !text-transparent bg-gradient-to-r blue-gradient bg-clip-text">{{ $post->title }}</h3>
                </a>
            </div>
            @endforeach
            {{--
        </div> --}}
    </div>
    @endif

</div>