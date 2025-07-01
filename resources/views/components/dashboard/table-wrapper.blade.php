@props(['data', 'tableTop' => null])
<div class="my-6 overflow-x-auto">
	{{-- search and filter --}}
	<div class="flex justify-between">
		<div class="flex justify-between gap-4 mb-2">
			<select wire:model="perPage" class="pr-8 w-min" name="perpage" id="perpage">
				<option value="5">{{__("5")}}</option>
				<option value="10">{{ __("10") }}</option>
				<option value="25">{{ __("25") }}</option>
				<option value="50">{{ __("50") }}</option>
				<option value="100">{{ __("100") }}</option>
			</select>

			{{$tableTop}}
		</div>

		<x-notices />

		{{-- front end interface has another message component included, thus this is only needed for admins --}}
		@if (Auth::user()->role == 'remwdstate20')
		<x-messages />
		@endif

		<div class="w-1/3">
			<input wire:model="keyword" type="text" placeholder="{{ __('Search in English') . ' ..' }}" />
		</div>
	</div>

	{{-- main table --}}
	<div class="table_wrapper">
		<table class="min-w-full">
			<thead>
				<tr>{{$header}}</tr>
			</thead>

			<tbody class="bg-white">
				{{$slot}}
			</tbody>
		</table>
	</div>

	{{-- pagination and info --}}
	<div class="mt-2">
		{{$data->links()}}
	</div>
</div>