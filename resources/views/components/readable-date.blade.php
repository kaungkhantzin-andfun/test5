@props(['date'])

<div class="flex gap-1 text-sm">
	<x-icon.icon :path="'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'" />
	@php
	$now = Illuminate\Support\Carbon::now();
	@endphp
	{{ $date->isYesterday() ? __('Yesterday') . ' ' . $date->format('H:i A') : ($date->diff($now)->days >= 1 ? $date->format('d-M-Y H:i A') :
	$date->diffForHumans()) }}
</div>