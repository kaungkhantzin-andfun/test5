<div>
    @if ($sortField != $field)
    <x-icon.icon class="ml-4" :add-class="true" path="M8 9l4-4 4 4m0 6l-4 4-4-4" />
    @elseif ($sortAsc)
    <x-icon.icon class="ml-4" :add-class="true" path="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
    @else
    <x-icon.icon class="ml-4" :add-class="true" path="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
    @endif
</div>