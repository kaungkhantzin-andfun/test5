<article class="overflow-hidden relative bg-white space-y-3
    {{$layout == 'horizontal' ? 'lg:grid lg:grid-cols-5' : ''}}">

	@php
	// getting translation from model attribute would cost extra queries
	// thus eager loaded and getting translations like this
	$translation = $property?->detail->where('locale', app()->getLocale())->first() ?:
	$property?->detail->first();
	@endphp

	{{-- Image --}}
	<div class="relative {{$layout == 'horizontal' ? 'lg:col-span-2' : ''}}">

		<a href="{{LaravelLocalization::localizeUrl('/properties/' . $property->id . '/' . $property->slug)}}">
			<img class="object-cover w-full {{ $layout == 'vertical' ? 'h-40' : ($layout == 'featured' ? 'h-60' : 'lg:border-b-0 h-52 max-h-72 lg:h-full')}}"
				src="{{ $property->images->first() ? Storage::url('card_' . $property->images->first()->path) : asset('assets/images/nia.jpg') }}"
				alt="{{$translation?->title}}">
		</a>

		<div class="absolute flex gap-4 bottom-4 right-4">
			{{-- Save/Unsave --}}
			@if (in_array($property->id, $savedPropertyIds))
			<!-- <span wire:click.prevent="unsave({{$property->id}})"
				class="block text-white shadow cursor-pointer icon-circle bg-gradient-to-tr from-red-500 right-4 to-red-900">
				<span class="tooltip">
					<x-icon.solid-icon
						path="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
					<span class="tooltiptext">Unsave</span>
				</span>
			</span> -->
			@else
			<!-- <span wire:click.prevent="save({{$property->id}})" class="block bg-white shadow cursor-pointer icon-circle">
				<span class="tooltip">
					<x-icon.icon
						path="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
					<span class="tooltiptext">Save</span>
				</span>
			</span> -->
			@endif
			{{-- End of Save/Unsave --}}

			{{-- Compare --}}
			@if (in_array($property->id, $compareIds))
			<span wire:click.prevent="removeCompare({{$property->id}})" class="block text-white cursor-pointer icon-circle bg-logo-blue">
				<span class="tooltip">
					<x-icon.solid-icon path="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
					<span class="tooltiptext">Not Compare</span>
				</span>
			</span>

			@else
			<!-- <span wire:click.prevent="compare({{$property->id}})" class="block bg-white cursor-pointer icon-circle text-logo-blue">
				<span class="tooltip">
					<x-icon.solid-icon path="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
					<span class="tooltiptext">Compare</span>
				</span>
			</span> -->
			@endif
			{{--End of Compare --}}

		</div>

	</div>

	{{-- Body --}}
	<div class="px-4 relative lg:col-span-3 space-y-3 {{$layout == 'horizontal' ? 'pb-4' : ''}}">

		<div class="space-y-1">
			<a class="text-xl font-semibold hover:underline"
				href="{{LaravelLocalization::localizeUrl('/properties/' . $property->id . '/' . $property->slug)}}">
				<h3 class="text-gradient">{{ $translation ? Str::limit($translation?->title, 65) : '' }}</h3>
			</a>
			{{-- <span class="flex text-xs">
				@php
				$created = $property->created_at;
				$now = Illuminate\Support\Carbon::now();
				@endphp
				{{ $created->diff($now)->days == 1 ? __('Yesterday') : ($created->diff($now)->days > 1 ? $created->format('d-M-Y') :
				$created->diffForHumans()) }}
			</span> --}}
		</div>

		@if (!empty($property->price))
		<div class="flex items-center justify-between w-full">
			<div class="flex items-center gap-1 text-gray-700">
				
				<span class="font-medium">{{ __('$') }}{{ floatval($property->price) }} /mo</span>
			</div>
			<div class="flex items-center gap-1  px-2 py-1 rounded">
				<svg class="w-6 h-6" fill="none" stroke="#CCCCCC" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
				</svg>
				
			</div>
		</div>
		@endif

		<div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center justify-between text-sm text-gray-600">
                @if (!empty($property->type))
                <span class="flex items-center gap-1" stroke="#CCCCCC">
                    <x-icon.icon class="w-4 h-4" :add-class="true"
                        path="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    <span>{{__($property->type->name)}}</span>
                </span>
                @endif

                @if (!empty($property->purpose))
                <span class="flex items-center gap-1" >
                    <x-icon.solid-icon stroke="#CCCCCC" class="w-4 h-4 " :add-class="true"
                        path="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" />
                    <span>{{__($property->purpose->name)}}</span>
                </span>
                @endif

                @if (count($property->location) > 0)
                <span class="flex items-center gap-1" >
                    <x-icon.icon stroke="#CCCCCC" class="w-4 h-4 " :add-class="true"
                        path="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" path2="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    @php
                    $tsp = $property->location->whereNotNull('parent_id')->first();
                    $region = $property->location->whereNull('parent_id')->first();
                    $reg = preg_split("/\s+(?=\S*+$)/", $region->name);
                    @endphp
                    <span>{{ trans($tsp->name) }}, {{ trans($reg[0] ?? '') }}</span>
                </span>
                @endif
            </div>
        </div>

		<!-- <div class="prose pb-3 min-h-[80px]">
			@if ($enquiryModal)
			{!! $translation?->detail !!}
			@else
			{!! $property->short_detail !!}
			@endif
		</div> -->

	</div>


	{{-- Footer --}}
	{{-- @if ($showUploader != false && !empty($property->user))
	<div class="absolute inset-x-0 bottom-0 flex flex-wrap items-center justify-between px-3 py-2 border-t"> --}}

		{{-- Uploader info --}}
		{{-- <div class="flex items-center max-w-full gap-2 text-left">
			<a class="w-12 h-12 overflow-hidden rounded-full"
				href="{{LaravelLocalization::localizeUrl('/real-estate-agents') . '/' . $property->user->slug}}">
				<img class="object-cover w-12 h-12"
					src="{{ $property->user->profile_photo_path != null ? Storage::url($property->user->profile_photo_path) : asset('assets/images/nia.jpg') }}"
					alt="">
			</a>

			<div class="truncate">
				<a class="text-sm font-semibold" href="{{LaravelLocalization::localizeUrl('/real-estate-agents') . '/' . $property->user->slug}}">{{
					$property->user->name }}</a>
			</div>
		</div> --}}

		{{-- @if ($property->user->role == 'user')
		<span class="px-2 py-1 text-sm font-bold text-white rounded-full bg-logo-purple">
			{{__('By Owner')}}
		</span>
		@endif --}}

		{{--
	</div>
	@endif --}}

</article>