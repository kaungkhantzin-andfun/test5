@props(['blog'])
<div class="overflow-hidden">
	<a href="{{LaravelLocalization::localizeUrl('/blog/' . $blog->id . '/' . $blog->slug)}}">
		@if ($blog->image != null)
		<img class="blog_card_img" src="{{ Storage::url('card_' . $blog->image->path) }}" alt="{{ $blog->title }}">
		@else
		<img class="blog_card_img" src="{{ asset('assets/images/nia.jpg') }}" alt="No image available" />
		@endif
	</a>

	<div class="relative p-4 prose">
		<span class="absolute left-0 flex items-center gap-2 px-3 py-2 text-xs font-bold rounded-r -top-4 bg-gradient-to-r blue-gradient">
			<x-icon.icon
				path="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
			{{ $blog->created_at->format('M j, Y') }}
		</span>
		<a class="no-underline" href="{{LaravelLocalization::localizeUrl('/blog/' . $blog->id . '/' . $blog->slug)}}">
			<h2 class="mt-4 mb-3 text-2xl leading-9 !text-transparent bg-gradient-to-r blue-gradient bg-clip-text">{{ $blog->title }}</h2>
		</a>

		@if (count($blog->categories) > 0)
		<div class="flex items-center gap-2 mt-4 mb-2 text-sm">
			<span class="!text-transparent bg-gradient-to-r blue-gradient bg-clip-text">
				<i class="fas fa-tags"></i>
			</span>
			<span class="flex flex-wrap gap-1">
				@forelse ($blog->categories as $cat)
				<span>
					<a class="font-bold text-logo-blue" href="{{LaravelLocalization::localizeUrl('/blog/' . $cat->slug)}}">
						{{ __( $cat->name)}}</a>{{$loop->last ? '' : ', '}}
				</span>
				@empty
				@endforelse
			</span>
		</div>
		@endif

		<div>{!! $blog->shortDetail !!}</div>
	</div>
</div>