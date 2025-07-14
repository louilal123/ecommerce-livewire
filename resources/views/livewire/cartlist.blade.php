<section class="w-full max-w-7xl mx-auto px-4 lg:mb-16">
   
    @include('components.toast-message')

    <div class="flex items-center justify-between mb-4 mt-4">
        <flux:heading size="xl" level="1">Your Cart</flux:heading>
    </div>

    <div class="mb-2">
        <flux:input.group>
            <flux:input
                placeholder="Search"
                icon="magnifying-glass"
                class="max-w-xs"
                wire:model.live="search"
            />
            <flux:input.group.suffix>Search</flux:input.group.suffix>
        </flux:input.group>
    </div>

    <div class="overflow-hidden  border-zinc-100 rounded-lg shadow dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Subtotal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-zinc-100 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse ($this->items as $item)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                 class="w-12 h-12 object-cover rounded" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $item->product->name }}</div>
                        </td>
                        <td class="px-6 py-4">₱{{ number_format($item->product->price, 2) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <flux:button size="xs" icon="minus" wire:click="decrementQuantity({{ $item->id }})" />
                                <span>{{ $item->quantity }}</span>
                                <flux:button size="xs" icon="plus" wire:click="incrementQuantity({{ $item->id }})" />
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            ₱{{ number_format($item->product->price * $item->quantity, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <flux:button wire:click="removeItem({{ $item->id }})"
                                         size="sm"
                                         variant="danger" class="cursor-pointer"
                                        >
                                Remove
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Your cart is empty.</td>
                         
                    </tr>
                    <tr><td colspan="6" class="text-center py-4  text-gray-500">Start by adding products.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

     <div class="mt-4">
       {{ $this->items->links() }}
    </div>

    <div class="mt-6 flex justify-end">
        <div class="w-full max-w-sm space-y-2">
            <div class="flex justify-between text-sm">
                <span>Subtotal</span>
                <span>₱{{ number_format($this->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span>Coupon Discount</span>
                <span class="text-green-600">-₱{{ number_format($this->discount, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold border-t pt-2">
                <span>Total</span>
                <span>₱{{ number_format($this->total, 2) }}</span>
            </div>
           <flux:radio name="paymentMethod" value="stripe" label="Pay with Card (Stripe)" wire:model.live="paymentMethod" />
            <flux:radio name="paymentMethod" value="cod" label="Cash on Delivery" wire:model.live="paymentMethod" />


            <flux:button wire:click="proceedToCheckout" variant="primary" class="w-full mt-4 cursor-pointer">
                Proceed to Checkout
            </flux:button>

        </div>
    </div>
</section>
