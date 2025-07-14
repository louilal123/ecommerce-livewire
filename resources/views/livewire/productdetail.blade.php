<section class="max-w-7xl mx-auto lg:px-4">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('home') }}">Lecommerce</flux:breadcrumbs.item>

        @if ($product->category)
            <flux:breadcrumbs.item>{{ $product->category->name }}</flux:breadcrumbs.item>
        @endif

        <flux:breadcrumbs.item>{{ $product->name }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="mt-4 mb-4 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="aspect-[4/3] mb-4 rounded-lg overflow-hidden bg-gray-100">
                @if ($mainImage)
                    <img
                        src="{{ asset('storage/' . $mainImage) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-contain"
                    />
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        No image
                    </div>
                @endif
            </div>

            <div class="flex space-x-2 overflow-x-auto">
                {{-- THIS LINE IS CHANGED: from $variantImages to $allProductImages --}}
                @foreach ($allProductImages as $value)
                    <img
                        src="{{ asset('storage/' . $value->image) }}"
                        alt="{{ $value->value }}"
                        class="w-16 h-16 rounded border object-cover cursor-pointer"
                        wire:click="$set('mainImage', '{{ $value->image }}')"
                    />
                @endforeach
            </div>
        </div>

        <div class="flex flex-col space-y-4">
            <flux:heading size="lg" class="leading-snug dark:text-white">{{ $product->name }}</flux:heading>

            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex text-yellow-400">
                    @for ($i = 0; $i < 5; $i++)
                        <svg class="w-4 h-4 {{ $i < 4 ? 'fill-current' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.954L10 0l2.951 5.956
                            6.561.954-4.756 4.635 1.122 6.545z"/>
                        </svg>
                    @endfor
                </div>
                <span>(23 ratings)</span>
            </div>

            <div class="text-3xl font-bold text-pink-600 dark:text-white">
                ₱{{ number_format($product->price, 2) }}
            </div>

          @foreach ($productAttributes as $attributeId => $attributeData)
    <div>
        <div class="mb-1 text-sm text-gray-600 dark:text-gray-400">{{ $attributeData['name'] }}</div>
        <div class="flex flex-wrap gap-2">
            @foreach ($attributeData['values'] as $value)
                <div
                    class="px-3 py-1 border rounded cursor-pointer
                    {{ isset($selectedAttributeValues[$attributeId]) && $selectedAttributeValues[$attributeId] === $value->id ? 'bg-pink-600 text-white' : 'hover:bg-pink-100 dark:text-white dark:hover:bg-gray-700' }}"
                    wire:click="$set('selectedAttributeValues.{{ $attributeId }}', {{ $value->id }})"
                >
                    @if ($attributeData['shows_image'] && $value->image)
                        <img src="{{ asset('storage/' . $value->image) }}" alt="{{ $value->value }}" class="w-6 h-6 inline-block mr-1 rounded-full object-cover">
                    @endif
                    {{ $value->value }}
                </div>
            @endforeach
        </div>
    </div>
@endforeach


            <div>
                <div class="mb-1 text-sm text-gray-600 dark:text-gray-400">Quantity</div>
                <div class="flex items-center gap-2">
                    <button class="px-2 py-1 border rounded dark:text-white dark:border-gray-700" wire:click="decrementQuantity">-</button>
                    <span class="dark:text-white">{{ $quantity }}</span>
                    <button class="px-2 py-1 border rounded dark:text-white dark:border-gray-700" wire:click="incrementQuantity">+</button>
                </div>
            </div>

            <div class="flex gap-3 mt-4">
                <div class="flex-1">
                    <livewire:addtocart-button :product-id="$product->id" :variant-id="$currentVariant->id ?? null" :quantity="$quantity" />
                </div>
                <flux:button variant="primary" class="flex-1">
                    {{ __('Buy Now') }}
                </flux:button>
            </div>

            @if (is_null($currentVariant))
                <div class="text-red-500 mt-2">
                    No variant found for the selected options.
                </div>
            @endif
        </div>
    </div>

    <div class="py-8">
        <flux:heading size="xl" class="mb-2" level="1">{{ __('Product Description') }}</flux:heading>
        <flux:subheading class="mb-4">{{ __('Reviews from customers.') }}</flux:subheading>
        <flux:separator />
    </div>

    <livewire:reviews />
</section>