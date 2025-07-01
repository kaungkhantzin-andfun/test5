<p>@lang('New enquiry from '){{ config('app.name') }}</p><br>

@lang('User details: ')<br><br>

@lang('Name'): {{ $enquiry->name }}<br>
@lang('Email'): {{ $enquiry->email }}<br>
@lang('Phone'): {{ $enquiry->phone }}<br>

@if (!empty($property))
@lang('Property'): <a
    href="{{config('app.url')}}/{{app()->getLocale()}}/properties/{{$property->id}}/{{$property->slug}}">{{ $property->translation->title }}</a><br>
@endif

@if (!empty($package))
@lang('Credit Package'): {{ $package['name'] }}<br>
@endif

@lang('Message'): {{  $enquiry->message }}<br>