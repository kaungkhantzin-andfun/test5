@props(['path', 'path2' => null, 'data', 'text'])
<div class="flex items-center px-5 py-6 bg-white border border-gray-200 rounded-md shadow-sm">
	<div class="p-3 rounded-full bg-gradient-to-tr blue-gradient">
		<x-icon.icon class="w-8 h-8 text-white" path="{{$path}}" path2="{{$path2}}" />
	</div>

	<div class="mx-5">
		<h4 class="text-2xl font-semibold text-gray-700">{{ number_format( $data ) }}</h4>
		<div class="text-gray-500">{{ __($text) }}</div>
	</div>
</div>