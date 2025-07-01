@props(['fill' => 'none', 'class' => 'w-5 h-5 2xl:w-6 2xl:h-6', 'path' => '', 'path2' => '', 'addClass' => false, 'strokeWidth' => '1.5'])
<svg {{$attributes}} class="shrink-0 {{$addClass ? " w-5 h-5 2xl:w-6 2xl:h-6 $class" : $class}}" stroke-width="{{$strokeWidth}}"
    xmlns="http://www.w3.org/2000/svg" fill="{{$fill}}" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" d="{{$path}}" />
    @if (!empty($path2))
    <path stroke-linecap="round" stroke-linejoin="round" d="{{$path2}}" />
    @endif
</svg>