<section>
    <blockquote class="container w-full max-w-xl mx-auto mb-8">
        <p class="text-grey-darkest">
            @field($fields['quotation'])
        </p>
        @if($fields['citation']['content'])
            <cite>
                @field($fields['citation'])
            </cite>
        @endif
    </blockquote>
</section>
