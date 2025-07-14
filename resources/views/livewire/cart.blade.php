
  <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
    <flux:dropdown placement="bottom-start">
        <div class="relative">
            <flux:navbar.item
                icon="shopping-cart"
                :label="__('Cart')"
                class="!h-10 [&>div>svg]:size-6 cursor-pointer"
            />
            @if ($this->totalQuantity > 0)
                <span class="absolute -top-1 -right-1 text-xs bg-red-600 text-white rounded-full px-1">
                    {{ $this->totalQuantity }}
                </span>
            @endif
        </div>

        <flux:menu class="w-80 max-h-[70vh] overflow-y-auto border-zinc-200">
             <div class="flex items-center justify-between py-4 px-2 border-b border-zinc-100">
                <flux:subheading size="sm" level="1">Your Cart</flux:subheading>
                 <span class="text-xs ">
                   Items: {{ $this->totalQuantity }}
                </span>
            </div>
             <flux:spacer />
            @forelse ($this->items as $item)
                <div class="flex items-start justify-between py-2 px-3 border-b border-zinc-100">
                    <div class="flex-1 pr-2">
                        <div class="font-semibold truncate">{{ $item->product->name }}</div>
                        <div class="text-sm text-gray-500">
                           ₱{{ number_format($item->product->price, 2) }} × {{ $item->quantity }}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm font-medium mr-2">
                            ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                        </span>
                        <button wire:click="removeItem({{ $item->id }})" class="text-red-600 hover:text-red-800">
                            <flux:icon.trash class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-sm px-3 py-4 text-center">
                    {{ __('Your cart is empty.') }}
                </div>
            @endforelse

            @if ($this->totalQuantity > 0)
                <div class="px-3 py-3 font-bold text-right border-t">
                    {{ __('Total:') }} ₱{{ number_format($this->totalAmount, 2) }}
                </div>
                
            <flux:button :href="route('cart')"  variant="primary" class="w-full mb-2 mt-2" color="pill" wire:navigate>
                {{ __('View Cart') }}
                
            </flux:button>
            @endif
            

            <flux:spacer />
           
        </flux:menu>
        
    </flux:dropdown>
</flux:navbar>
