@props(['placement' => null])
@php
	// $ads is coming appserviceprovier
	$advertisements = $ads->where('placement', $placement);
@endphp

@if (count($advertisements) > 0)
	@foreach ($advertisements as $ad)
		@if (!empty($ad->link))
		<a class="overflow-hidden rounded" href="{{ $ad->link }}" target="_blank" rel="nofollow">
			<img src="{{ Storage::url($ad->image->path) }}" alt="{{ $ad->name }}">
		</a>
		@else
		<img class="rounded" src="{{ Storage::url($ad->image->path) }}" alt="{{ $ad->name }}">
		@endif
	@endforeach
@else
	<div class="px-8 py-6 text-2xl text-center border-4 border-gray-300 rounded md:w-full w-max">
		<p>{{ __('Advertise here!') }}</p>
	</div>
@endif