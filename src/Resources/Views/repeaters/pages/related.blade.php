<section>
    <div class="flex flex-wrap max-w-xl m-auto">
        @foreach($fields as $field)
            @foreach(Agencms\Pages\Models\Page::prioritised()->whereIn('id', array_wrap(optional($field)['content']))->get() as $page)
                <div class="w-full p-4 mb-8 md:w-1/2">
                    <a href="{{ route('page', $page->slug) }}" class="no-underline text-grey-darker">
                        <div class="rounded overflow-hidden">
                            @if ($page->image)
                                <img class="w-full" src="{{ $page->image }}" alt="{{ $page->name }}">
                            @endif
                            <div class="px-6 py-4">
                                <h3 class="font-bold text-xl mb-2">{{ $page->name }}</h3>
                                <p class="text-grey-darker text-base">
                                    {{ $page->summary }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @endforeach
    </div>
</section>
