@props(['delId', 'itemId'])
<span class="tooltip">
	@if ($delId === $itemId)
	<a class="text-red-500 hover:text-red-600" wire:click="delItem()" href="#">{{__('Sure?')}}</a>
	@else
	<a wire:click="$set('del_id', {{$itemId}})" class="text-red-500 hover:text-red-600" href="#">
		<x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
	</a>
	@endif
	<span class="tooltiptext tt-top">{{ __('Delete') }}</span>
</span>