{{--  Render a lead repeater field  --}}

<section>
    <div class="flex flex-col">
        <div class="overlay-top-down bg-cover bg-center min-h-screen flex justify-center text-center mb-8 items-center" style="background-image: url({{ $fields['image']['content'] }})">
            <div class="flex flex-col h-full my-8 z-10">
                <h1 class="block text-grey-lightest text-shadow-dark font-hairline tracking-wide text-5xl mb-4">
                    @field($fields['title'])
                </h1>
                <p class="text-grey-lightest font-hairline tracking-wide text-shadow-dark">
                    @field($fields['subtitle'])
                </p>
            </div>
        </div>
    </div>
</section>
