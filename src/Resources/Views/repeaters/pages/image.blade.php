{{--  Render an image repeater field  --}}

@if (optional($fields)['image'])
    <div class="container w-full max-w-xl mx-auto mb-8">
        @if ($href = $fields['href']['content'])
            <a href="{{ $href }}">
        @endif
        <img src="{{ $fields['image']['content'] }}" alt="{{ $fields['alt']['content'] }}" class="">
        @if ($href)
            </a>
        @endif
    </div>
@endif
