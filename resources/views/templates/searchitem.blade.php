    {{-- <a href="{{ route('document', ['lang' => app()->getLocale(), 'registrationNumber' => $item['_source']['registration_number']]) }}" class="list-group-item list-group-item-action py-3 mb-3" aria-current="true">
        <div class="d-flex gap-2 w-100 justify-content-left">
            <div>
                <x-bi-link-45deg class="w-8 h-8 text-primary opacity-75"/>
            </div>
            <div>
                <h3 class="fs-6 mb-1 overflow-hidden">
                    {{ \Helpers::getItemFromArray($item['_source']['description'], ["description_type" => "title", "description_language" => app()->getLocale() ?? "ua"], "description_text") }}
                </h3>
                <div class="h6 fs-6 mb-3 text-primary opacity-85">
                    {{ $item['_source']['registration_number'] }}
                </div>
            </div>
        </div>
        <div class="founded text-muted">
            @foreach($item['highlight'] ?? [] as $field=>$list)
                <h4 class="fs-6 mt-1 mb-0">{!! __('app.fields')[$field] ?? '' !!}</h4>
                <p class="m-0 ">
                @foreach($list as $line)
                    {!! $line !!}
                @endforeach
                </p>
            @endforeach
        </div>
    </a> --}}

    <a href="{{ route('document', ['lang' => app()->getLocale(), 'registrationNumber' => $item['_source']['registration_number']]) }}" target="_blank" class="list-group-item list-group-item-action d-flex gap-3 py-3 mb-3" aria-current="true">
        <div>
            <x-bi-link-45deg class="w-8 h-8 text-primary opacity-75"/>
        </div>
        <div class="d-flex gap-2 w-100 justify-content-between">
            <div>
                <h3 class="fs-6 mb-1 overflow-hidden">
                    {{ \Helpers::getItemFromArray($item['_source']['description'], ["description_type" => "title", "description_language" => app()->getLocale() ?? "ua"], "description_text") }}
                </h3>
                <div class="h6 fs-6 mb-3 text-primary opacity-85">
                    {{ $item['_source']['registration_number'] }}
                </div>

                <div class="founded small">
                    @foreach($item['highlight'] ?? [] as $field=>$list)
                        {{-- <h4 class="fs-6 mt-1 mb-0">{!! __('app.fields')[$field] ?? '' !!}</h4> --}}
                        <p class="m-0 ">
                        @foreach($list as $line)
                            {!! $line !!}
                        @endforeach
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </a>
