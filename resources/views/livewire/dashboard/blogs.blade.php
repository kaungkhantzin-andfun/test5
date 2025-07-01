<x-dashboard.table-wrapper :data="$blogs">
    <x-slot name="header">

        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('title')" role="button" href="#">
                {{ __('Title') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" field="title" />
            </a>
        </th>
        <th class="user_th">{{ __('Image') }}</th>
        <th class="user_th">{{ __('Body') }}</th>
        <th class="user_th">{{ __('Categories') }}</th>

        @if (Auth::user()->role == 'remwdstate20')
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('user_id') role=" button" href="#">
                {{ __('Uploaded By') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" field="user_id" />
            </a>
        </th>
        @endif

        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('created_at') role=" button" href="#">
                {{ __('Created At') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" field="created_at" />
            </a>
        </th>

        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('updated_at') role=" button" href="#">
                {{ __('Updated At') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" field="updated_at" />
            </a>
        </th>

        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('stat')" role="button" href="#">
                {{ __('Views') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'stat'" />
            </a>
        </th>

        <th class="user_th">{{ __('Manage') }}</th>

    </x-slot>

    @forelse ($blogs as $blog)
    <tr>
        <td class="user_td">{{$blog->title}}</td>
        <td class="user_td">
            @if ($blog->image != null)
            <img class="rounded" src="{{ Storage::url('thumb_' . $blog->image->path) }}" alt="{{ $blog->title }}">
            @else
            <img class="rounded" src="{{ asset('assets/images/nia.jpg') }}" alt="No image available" />
            @endif
        </td>
        <td class="user_td">{!! \Str::limit($blog->body, 100) !!}</td>
        <td class="user_td">
            @foreach ($blog->categories as $category)
            {{$category->name}}{{$loop->last ? '' : ','}}
            @endforeach
        </td>
        <td class="user_td">{{$blog->user->name}}</td>
        <td class="user_td">{{$blog->created_at->format('d-M-y')}}</td>
        <td class="user_td">{{$blog->updated_at->format('d-M-y')}}</td>
        <td class="user_td">
            {{number_format($blog->stat)}}
        </td>
        <td class="p-2 user_td">
            <p class="flex gap-4">
                <span class="tooltip">
                    <a href="{{LaravelLocalization::localizeUrl('/blog/' . $blog->id . '/' . $blog->slug)}}" target="_blank"
                        class="text-yellow-400 hover:text-yellow-700 tooltip">
                        <x-icon.icon :path="'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'" />
                    </a>
                    <span class="tooltiptext">{{ __('Open in new tab') }}</span>
                </span>

                <a href="{{LaravelLocalization::localizeUrl('/dashboard/blog-posts/' . $blog->id . '/edit')}}"
                    class="text-gray-600 hover:text-gray-900 tooltip">
                    <x-icon.icon
                        :path="'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </a>

                <x-delete-button :del-id="$del_id" :item-id="$blog->id" />
            </p>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="8" class="p-8 text-center">
            <p>No posts found!</p>
        </td>
    </tr>
    @endforelse

</x-dashboard.table-wrapper>