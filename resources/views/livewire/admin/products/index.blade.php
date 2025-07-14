<div>

    <div class="flex items-center justify-between mb-2">
       <flux:heading size="xl" level="1">Manage Products </flux:heading>
        <div class="flex justify-end">
         <flux:button :href="route('admin.products.create')"  wire:navigate variant="primary" color="indigo" class="cursor-pointer" icon="plus">Add New Product</flux:button>
                  
        </div>
    </div>
    <div class="mb-2">
          <flux:input.group> 
            <flux:input placeholder="Search"  icon="magnifying-glass" class="max-w-xs" wire:model.live="search"/>  
             <flux:input.group.suffix>Search</flux:input.group.suffix>
           </flux:input.group>
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
                        Price
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
             <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse($products as $product)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800"wire:key="product-{{ $product->id }}">
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                ₱{{ number_format($product->price, 2) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                   ($product->stock > 0 ? 'bg-red-100 text-gray-800 dark:bg-red-900 dark:text-white' : 
                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                      <td class="px-6 py-4">
                            <flux:badge color="orange">
                                {{ $product->category?->fullPath() ?? 'Uncategorized' }}
                            </flux:badge>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                         <flux:button  class="cursor-pointer" size="sm" > Edit </flux:button>
                        <flux:button wire:click="confirmDelete({{ $product->id }})" variant="danger" class="cursor-pointer" size="sm">
                            Delete
                        </flux:button>
                        </td>
                    </tr>
                   
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center">
                            <div class="text-zinc-500 dark:text-zinc-400">
                                <p class="text-lg">No products found</p>
                               
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $products->links() }}
    </div>
       
        <flux:modal name="confirm-delete-modal" class="w-128">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete Product?</flux:heading>
                    <flux:text class="mt-2">
                        <p>You're about to delete <strong>{{ $productName }}</strong>. This action cannot be undone.</p>
                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost" class="cursor-pointer">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:modal.close>
                        <flux:button wire:click="delete" variant="danger" class="cursor-pointer">
                            Delete Product
                        </flux:button>
                    </flux:modal.close>
                </div>
            </div>
        </flux:modal>
</div>