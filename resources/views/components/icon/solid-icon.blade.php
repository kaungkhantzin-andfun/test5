@props(['fill' => 'none', 'class' => 'w-5 h-5 2xl:w-6 2xl:h-6', 'path' => '', 'path2' => '', 'addClass' => false])

<svg {{$attributes}} class="shrink-0 {{$addClass ? " w-5 h-5 2xl:w-6 2xl:h-6 $class" : $class}}" xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="{{$path}}" clip-rule="evenodd" />
  @if (!empty($path2))
  <path d="{{ $path2 }}" />
  @endif
</svg>