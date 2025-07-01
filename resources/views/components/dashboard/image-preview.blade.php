@props(['images'])

<div class="my-4 space-y-2">

	<h3 class="font-semibold text-gray-600">{{__('Property images')}}</h3>

	<div wire:sortable="updateImageOrder" class="grid items-start grid-cols-6 gap-3">

		@foreach ($images as $index => $image)
		<div wire:sortable.item="{{$index}}" wire:key="img-{{$index}}" class="relative max-w-[110px]" x-data="{sure: false}">

			@if (is_array($image) && !empty($image['id']))
			<img wire:sortable.handle class="object-cover border rounded max-h-20" src="/storage/thumb_{{ $image['path'] }}" />
			@else
			<img wire:sortable.handle class="object-cover border rounded max-h-20" src="{{ $image->temporaryUrl() }}" />
			@endif

			<a wire:click.prevent="delImage({{ $index }})" x-show="sure" @click="sure = false" @click.away="sure = false"
				class="h-6 p-1 text-xs font-semibold img_del" href="#">{{__('Sure?')}}</a>

			<x-icon.icon x-show="!sure" @click="sure = true" class="img_del" path="M6 18L18 6M6 6l12 12" />

		</div>
		@endforeach

	</div>

</div>