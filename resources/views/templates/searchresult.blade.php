<div class="row" id="searchResults">

    @unless(empty($data))
    {{-- 
    <div class="col-12">
        <div class="h-80 p-5 text-white bg-secondary text-center rounded-3 my-4">
            <h2 class="display-6">BANNER</h2> 
        </div>
    </div>
    --}}
    @endunless


    <div class="col">
    @if(!empty($fill['btnSearch']))
        <div class="row">
            <div class="col">
                <h2 class="h3">{{ __('app.search_result_header') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
            @if(!empty($data))
                <p>{{ trans_choice("app.search_result_total", Str::take(Str::reverse((string)$total), 1), ['value' => $total])}}</p>
                @if ($limited)
                    <div class="alert alert-danger">@lang('app.search_limited')</div>
                @endif
            @else
                <p>{{ __('app.search_no_result')}}</p>
            @endif
            </div>
        </div>
    @endif


    @unless(empty($data))
        <div class="row">
            <div class="col">
                <div class="mb-2">
                    {{ $data->onEachSide(1)->links() }}
                </div>
                @foreach($data as $item)
                <div class="list-group overflow-hidden">
                    @include('templates.searchitem')
                </div>
                @endforeach
                <div class="mt-4">
                    {{ $data->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    @endunless

    </div>
    <input type="hidden" id="isBtnSearch" value="{{ $fill['btnSearch'] ?? 0 }}">
</div>
