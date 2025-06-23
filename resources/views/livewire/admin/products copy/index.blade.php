<div class="space-y-6">
    @if (session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="font-medium leading-5">{{ session('success') }}</p>
            </div>
            <button wire:click="$dispatch('close-notification')" class="text-white hover:text-white/80">&times;</button>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold tracking-tight">Products</h1>
        <div class="flex justify-end mb-4">
            <flux:modal.trigger name="create-product">
                <flux:button class="mt-4 justify-content-end bg-blue-700">Create Product</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <div class="overflow-hidden bg-white border rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="h-12 w-12 object-cover" alt="{{ $product->name }}" />
                            @else
                                <div class="h-12 w-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-xs text-gray-400">No Image</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $product->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 max-w-xs truncate">
                                {{ $product->description ?: 'No description' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                ₱{{ number_format($product->price, 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : 
                                   ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 
                                    'bg-red-100 text-red-800') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:modal.trigger name="edit-product">
                                <flux:button wire:click="$dispatch('edit-product', { id: {{ $product->id }} })">
                                    Edit
                                </flux:button>
                            </flux:modal.trigger>

                            <flux:modal.trigger name="delete-product-{{ $product->id }}">
                                <flux:button variant="danger">
                                    Delete
                                </flux:button>
                            </flux:modal.trigger>
                        </td>
                    </tr>

                    <flux:modal name="delete-product-{{ $product->id }}" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Delete Product?</flux:heading>
                                <flux:text class="mt-2">
                                    <p>You're about to delete "{{ $product->name }}".</p>
                                    <p>This action cannot be reversed.</p>
                                </flux:text>
                            </div>
                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:modal.close>
                                    <flux:button wire:click="delete({{ $product->id }})" variant="danger">
                                        Delete Product
                                    </flux:button>
                                </flux:modal.close>
                            </div>
                        </div>
                    </flux:modal>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <p class="text-lg">No products found</p>
                                <p class="text-sm mt-1">Get started by adding your first product.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
    
    @livewire('admin.products.create')
    @livewire('admin.products.edit')
</div>