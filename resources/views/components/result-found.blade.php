@props(['properties' => null, 'class' => null])
<div class="flex items-center justify-center gap-1 label info {{$class}}">
	@if (count($properties) > 0)

	<x-loading-indicator />

	<x-icon.solid-icon
		path="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
	{{ __('mytranslations.results_found', ['count' => number_format($properties->total())]) }}

	@else

	<x-loading-indicator />

	<x-icon.solid-icon class="text-red-600" :add-class="true"
		path="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" />
	<span class="text-red-600">{{ __('No properties found!') }}</span>
	@endif
</div>