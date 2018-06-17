{{--  Render a text repeater field  --}}

<section>
    <div class="flex flex-col">
        <div class="flex items-center justify-center mb-8">
            <div class="flex flex-col justify-around h-full w-full max-w-lg">
                <div class="text-grey-darkest mb-6 rte">
                    @markdown($fields['text']['content'])
                </div>
            </div>
        </div>
    </div>
</section>
