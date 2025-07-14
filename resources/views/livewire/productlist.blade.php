<div class=" max-w-7xl mx-auto lg:px-4">
    <flux:heading size="xl" class=" mb-2" level="1">{{ __('Products') }}</flux:heading>
    <flux:subheading class="mb-4">{{ __('Browse our products') }}</flux:subheading>
      
    @include('components.toast-message')

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @forelse ($products as $product)
            <div class="group  cursor-pointer border rounded-xl shadow hover:shadow-md transition-all duration-300 p-4 h-[340px] flex flex-col">
            
                <div class="relative aspect-[4/3] w-full mb-3 overflow-hidden rounded-lg">
                    <a href="{{ route('product.show', $product->slug) }}" class="block" wire:navigate>
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300" 
                            loading="lazy"
                        />
                    </a>
                </div>

                <flux:heading size="sm" class="mb-1 line-clamp-2 dark:text-white">
                    {{ $product->name }}
                </flux:heading>

                <div class="flex items-center mb-2">
                    <div class="flex text-yellow-400">
                        @for ($star = 1; $star <= 5; $star++)
                            <svg class="w-3 h-3 {{ $star <= 4 ? 'fill-current' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.561-.954L10 0l2.951 5.956 
                                6.561.954-4.756 4.635 1.122 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-gray-500 text-xs ml-1 dark:text-gray-400">(23)</span>
                </div>

                <div class="mt-auto">
                    <div class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                        ₱{{ number_format($product->price, 2) }}
                        @if ($product->original_price)
                            <span class="text-xs text-gray-500 line-through ml-1.5 dark:text-gray-400">
                                ₱{{ number_format($product->original_price, 2) }}
                            </span>
                        @endif
                    </div>

                   <livewire:addtocart-button :product-id="$product->id" />
                </div>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">
                No products found.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
     <div>
        Be like water.
    </div>
</div>
