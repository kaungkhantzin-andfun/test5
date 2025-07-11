@extends('translation::layout')

@section('body')

<form action="{{ route('languages.translations.index', ['language' => $language]) }}" method="get">
    @csrf

    <div class="panel">

        <div class="panel-header">

            {{ __('translation::translation.translations') }}

            <div class="flex items-center justify-end grow">

                @include('translation::forms.search', ['name' => 'filter', 'value' => Request::get('filter')])

                @include('translation::forms.select', ['name' => 'language', 'items' => $languages, 'submit' => true, 'selected' => $language])

                <div class="items-center sm:hidden lg:flex">

                    @include('translation::forms.select', ['name' => 'group', 'items' => $groups, 'submit' => true, 'selected' =>
                    Request::get('group'), 'optional' => true])

                    <a href="{{ route('languages.translations.create', $language) }}" class="button">
                        {{ __('translation::translation.add') }}
                    </a>

                </div>

            </div>

        </div>

        <div class="panel-body">

            @if(count($translations))

            <table>

                <thead>
                    <tr>
                        <th class="w-1/5 font-thin uppercase">{{ __('translation::translation.group_single') }}</th>
                        <th class="w-1/5 font-thin uppercase">{{ __('translation::translation.key') }}</th>
                        <th class="font-thin uppercase">{{ config('app.locale') }}</th>
                        <th class="font-thin uppercase">{{ $language }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($translations as $type => $items)

                    @foreach($items as $group => $translations)

                    @foreach($translations as $key => $value)

                    @if(!is_array($value[config('app.locale')]))
                    <tr>
                        <td>{{ $group }}</td>
                        <td>{{ $key }}</td>
                        <td>{{ $value[config('app.locale')] }}</td>
                        <td>
                            <translation-input initial-translation="{{ $value[$language] }}" language="{{ $language }}" group="{{ $group }}"
                                translation-key="{{ $key }}" route="{{ config('translation.ui_url') }}">
                            </translation-input>
                        </td>
                    </tr>
                    @endif

                    @endforeach

                    @endforeach

                    @endforeach
                </tbody>

            </table>

            @endif

        </div>

    </div>

</form>

@endsection