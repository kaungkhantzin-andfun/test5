<div>
    <form wire:submit.prevent="{{$createMode ? 'createItem' : 'saveItem'}}">
        @csrf
        <div class="max-w-lg mt-4 space-y-4">
            <x-input.text label="Friendly Name" model="ad.name" />

            <x-input.select label="Placement" model="ad.placement">
                <option value="header">{{__('Header')}}</option>
                <option value="companies">{{__('Featured Companies')}}</option>
                <option value="sidebar">{{__('Sidebar')}}</option>
                <option value="under_featured">{{__('Under Featured Properties')}}</option>
                <option value="single">{{__('All Single Property Pages')}}</option>
            </x-input.select>

            <x-input.text label="Link (optional)" model="ad.link" />

            <x-input.text type="date" label="Expiry date" model="ad.expiry" />

            <div>
                <label class="block w-full text-sm font-medium" for="image">{{ __('Image') . ':' }}</label>

                <input wire:model="img" class="w-full" type="file" id="image">

                @if (!empty($ad->placement) && !empty($acceptedDimension))
                <span
                    class="w-full text-sm text-blue-500">{{ __('The accepted image dimension for ' . ucwords(str_replace('_', ' ', $ad->placement)) . ' placement is ' . $acceptedDimension . '.') }}</span>
                @endif

                @error('img') <span class="block text-sm font-medium text-red-600">{{ $message }}</span> @enderror

                @if ($img != null)
                <img class="mt-4 rounded shadow-md" src="{{$img->temporaryUrl()}}" />
                @elseif ($oldImg != null)
                <img class="mt-4 rounded shadow-md" src="/{{$oldImg}}" />
                @endif
            </div>

            <input type="submit" value="{{ __('Save') }}"
                class="float-right py-2 text-white bg-gradient-to-r blue-gradient btn">

        </div>
    </form>
</div>