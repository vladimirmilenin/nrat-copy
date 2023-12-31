@unless(empty($registrationNumber))
<a href="{{ $url }}" class="list-group-item list-group-item-action d-flex gap-3 py-3" @unless (empty($target)) target={{ $target }} @endunless aria-current="true">
    <x-bi-link-45deg class="w-8 h-8 text-primary opacity-75"/>
    <div class="d-flex gap-2 w-100 justify-content-between">
        <div>
            <h3 class="h6 mb-0">{{ $registrationNumber }}</h3>
            @unless (empty($author))
            <p class="mb-0 overflow-x-hidden">{!! $author !!}</p>
            @endunless
            <p class="mb-0 opacity-75 overflow-x-hidden">{!! $theme !!}</p>
        </div>
    </div>
</a>
@endunless

