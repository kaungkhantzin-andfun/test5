@props(['path' => null])
@php
// Getting only video code from url then convert to embed code
$parts = parse_url($path);
if ($parts != Null && array_key_exists('host', $parts)) {
	if (Str::contains($parts['host'], 'youtu.be')) {
		$video_code = Str::replace('/', '', $parts['path']);
	} else {
		parse_str($parts['query'], $query);
		$video_code = $query['v'];
	}
}
@endphp

<iframe src="https://www.youtube.com/embed/{{$video_code}}" frameborder=0 allowfullscreen></iframe>