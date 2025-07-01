@props(['label' => false, 'model', 'id' => Str::of($label)->slug()->replace('-', '')])
<div>
    <div wire:ignore wire:model.lazy="{{$model}}" x-data x-init="
        ClassicEditor
            .create($refs.{{$id}}, {
                @if (Auth::user()->role != 'remwdstate20')

                @if (Route::is('dashboard.pptedit') || Route::is('dashboard.pptcreate') || Route::is('dashboard.edit-post') || Route::is('dashboard.create-post'))
                   removePlugins: ['Link', 'ImageUpload', 'MediaEmbed', 'Heading', 'BlockQuote'],
                @endif

                @if (Route::is('dashboard.slider.create') || Route::is('dashboard.slider.edit'))
                   removePlugins: ['MediaEmbed', 'Heading', 'BlockQuote', 'ImageUpload', 'Table'],
                @endif

                @endif
                simpleUpload: { uploadUrl: '{{route('ckeditor.upload')}}' },
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'underline',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'outdent',
                        'indent',
                        '|',
                        'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'mediaEmbed',
                        'undo',
                        'redo'
                    ]
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                }
            })
            .then(editor => {
                editor.model.document.on('change', () => {
                    $dispatch('change', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
        " class="w-full">

        <label class="label">{{__($label)}}</label>

        <span class="items-center hidden gap-1 lg:flex info">
            <x-icon.solid-icon class="w-4 h-4"
                path="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
            {{__('Ctrl+Shift+V to paste without format.')}}
        </span>

        <div x-ref="{{$id}}">
            {{$slot}}
        </div>

    </div>

    @error($model) <span class="error">{{ $message }}</span> @enderror
</div>

@once
@push('f_scripts')
{{-- for users front end ppt upload form --}}
<script src="{{ asset('assets/js/ckeditor.js') }}"></script>
@endpush
@push('scripts')
{{-- for admin --}}
<script src="{{ asset('assets/js/ckeditor.js') }}"></script>
@endpush
@endonce