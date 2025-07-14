<div>
    <div class="flex items-center justify-between mb-4">
        <flux:heading size="xl">Manage Orders</flux:heading>
    </div>

    <div class="mb-2">
        <flux:input.group>
            <flux:input
                placeholder="Search by Product"
                icon="magnifying-glass"
                class="max-w-xs"
                wire:model.live="search"
            />
        </flux:input.group>
    </div>

    <div class="overflow-hidden bg-white border rounded-lg shadow dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Payment Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse ($orders as $order)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $order->user?->name }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">#{{ $order->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-y-1 text-sm">
                            @foreach ($order->items as $item)
                                <div class="text-zinc-700 dark:text-zinc-300">
                                    {{ $item->quantity }}× {{ $item->product->name }}
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">(₱{{ number_format($item->price, 2) }})</span>
                                </div>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                            <flux:badge color="green">{{ $order->status }}</flux:badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-800 dark:text-zinc-200">
                            ₱{{ number_format($order->total, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                            <flux:badge variant="pill">{{ $order->payment_method }}</flux:badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $order->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400 space-x-2">
                            <flux:button variant="primary" size="sm" class="cursor-pointer" color="emerald">View</flux:button>
                            <flux:button variant="danger" size="sm" class="cursor-pointer">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                            <p class="text-lg">No orders found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    <div>
        A good traveler has no fixed plans and is not intent upon arriving.
    </div>
</div>
