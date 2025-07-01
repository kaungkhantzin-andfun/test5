@props(['slide', 'class' => null])
<img class="object-cover w-screen aspect-video {{$class}}"
	srcset="{{Storage::url('small_' . $slide->image->path)}} 640w, {{Storage::url('medium_' . $slide->image->path)}} 1024w, {{Storage::url($slide->image->path)}} 1500w"
	sizes="100vw" src="{{Storage::url($slide->image->path)}}" alt="{{$slide->image->caption ?: ''}}">