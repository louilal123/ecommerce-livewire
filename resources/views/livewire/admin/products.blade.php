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
                <flux:button  class="mt-4 justify-content-end bg-blue-700">Create Product</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <div class="overflow-hidden bg-white border rounded-lg shadow dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Image
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Description
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Price
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse($products as $product)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="h-12 w-12 object-cover " 
                                     alt="{{ $product->name }}" />
                            @else
                                <div class="h-12 w-12 bg-zinc-100 dark:bg-zinc-800 rounded-lg flex items-center justify-center">
                                    <span class="text-xs text-zinc-400">No Image</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $product->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-zinc-600 dark:text-zinc-400 max-w-xs truncate">
                                {{ $product->description ?: 'No description' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                ₱{{ number_format($product->price, 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                   ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 
                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:modal.trigger name="edit-product">
                                <flux:button wire:click="edit({{ $product->id }})">
                                    Edit
                                </flux:button>
                            </flux:modal.trigger>

                            <flux:modal.trigger name="delete-product-{{ $product->id }}">
                                <flux:button size="sm" variant="danger">
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
                            <div class="text-zinc-500 dark:text-zinc-400">
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
    
    <div>
        <flux:modal name="create-product" class="w-full max-w-3xl">
            <div wire:loading wire:target="edit" class="text-center py-8">
                <svg class="animate-spin h-8 w-8 mx-auto mb-4" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading product details...
            </div>
            <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <flux:heading size="lg">Add New Product</flux:heading>
                    <flux:subheading class="mt-2">Fill in the product details below.</flux:subheading>
                </div>

                <div class="space-y-4">
                    <flux:input label="Product Name" wire:model.defer="name" required />
                    <flux:textarea label="Description" wire:model.defer="description" rows="3" />
                    <flux:input label="Price" type="number" step="0.01" wire:model.defer="price" required />
                    <flux:input label="Stock Quantity" type="number" min="0" wire:model.defer="stock" required />
                    <flux:input label="Image" type="file" wire:model="image" accept="image/*" />
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
                    <flux:modal.close>
                        <flux:button type="button" variant="ghost">
                            Cancel
                        </flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        Create Product
                    </flux:button>
                </div>
            </form>
        </flux:modal>

        <flux:modal name="edit-product" class="w-full max-w-3xl">
            
            <form wire:submit.prevent="update" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <flux:heading size="lg">Edit Product</flux:heading>
                    <flux:subheading class="mt-2">Update the product details below.</flux:subheading>
                </div>

                <div class="space-y-4">
                    <flux:input label="Product Name" wire:model.defer="name" required />
                    <flux:textarea label="Description" wire:model.defer="description" rows="3" />
                    <flux:input label="Price" type="number" step="0.01" wire:model.defer="price" required />
                    <flux:input label="Stock Quantity" type="number" min="0" wire:model.defer="stock" required />
                    <flux:input label="Image" type="file" wire:model="image" accept="image/*" />

                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg border" alt="Preview" />
                    @elseif ($currentImageUrl)
                        <img src="{{ $currentImageUrl }}" class="h-20 w-20 object-cover rounded-lg border" alt="Current Image" />
                    @endif
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
                    <flux:modal.close>
                        <flux:button wire:click="resetForm" type="button" variant="ghost">
                            Cancel
                        </flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">
                        Update Product
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    </div>
</div>