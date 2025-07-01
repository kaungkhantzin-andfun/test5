<x-dashboard.table-wrapper :data="$sliders">
    <x-slot name="header">
        <th class="user_th">{{ __('Image') }}</th>
        <th class="user_th">{{ __('Title') }}</th>
        <th class="user_th">{{ __('Caption') }}</th>
        <th class="user_th">{{ __('Actions') }}</th>
    </x-slot>

    @foreach ($sliders as $slider)
    @php
    $firstImg = App\Models\Image::where('imageable_id',
    $slider->id)->whereIn('imageable_type',['slider','testimonial','youtube'])->first();
    @endphp
    <tr>
        <td class="user_td">
            @if (!empty($firstImg))

            @if ($firstImg->imageable_type != 'youtube')
            <img class="rounded w-36" src="{{Storage::url('small_' . $firstImg->path)}}" />
            @else
            <x-youtube-video :path="$firstImg->path" />
            @endif

            @endif
        </td>
        <td class="user_td">{{$slider->name}}</td>
        <td class="user_td">
            @if (!empty($firstImg))
            {!!$firstImg->caption!!}
            @endif
        </td>
        <td class="user_td">
            <p class="flex">
                <a href="{{LaravelLocalization::localizeUrl('/dashboard/sliders/' . $slider->id . '/edit')}}"
                    class="mr-8 text-gray-600 tooltip hover:text-gray-900">
                    <x-icon.icon
                        path="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </a>
                <x-delete-button :del-id="$del_id" :item-id="$slider->id" />
            </p>
        </td>
    </tr>
    @endforeach
</x-dashboard.table-wrapper>