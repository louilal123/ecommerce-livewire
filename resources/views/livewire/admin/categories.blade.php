<div>
    <div class="flex items-center justify-between mb-2">
        <flux:heading size="xl">Manage Categories</flux:heading>
        <flux:button wire:click="create" variant="primary" color="indigo" class="cursor-pointer" icon="plus">
            Add Category
        </flux:button>
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
    <div class="overflow-hidden bg-white border rounded-lg  shadow dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse ($categories as $category)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                    class="h-12 w-12 object-cover rounded"
                                    alt="{{ $category->name }}" />
                            @else
                                <div class="h-12 w-12 bg-zinc-100 dark:bg-zinc-800 rounded flex items-center justify-center">
                                    <span class="text-xs text-zinc-400">No Image</span>
                                </div>
                            @endif
                        </td>

                        <td class="">
                            <div class="text-sm  font-medium text-zinc-900 dark:text-zinc-100">
                                  <flux:link class="text-sm cursor-pointer" href="{{ route('admin.category.subcategory', ['categoryPath' => $category->slug]) }}" 
                                       wire:navigate>{{ $category->name }}
                                  </flux:link>
                                  
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap max-w-sm truncate text-sm text-zinc-600 dark:text-zinc-400">
                            {{ Str::limit($category->description, 100) ?: '—' }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:button wire:click="edit({{ $category->id }})" variant="filled"  size="sm" class="cursor-pointer">
                                Edit
                            </flux:button>
                               <flux:button wire:click="confirmDelete({{ $category->id }})" variant="danger" class="cursor-pointer" size="sm">
                            Delete
                        </flux:button>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-zinc-500 dark:text-zinc-400">
                            <p class="text-lg">No categories found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

    <flux:modal name="category-form" class="w-full max-w-3xl">
        <form wire:submit.prevent="{{ $categoryId ? 'update' : 'save' }}" class="space-y-6" enctype="multipart/form-data">
            <flux:heading size="lg">{{ $categoryId ? 'Edit Category' : 'Add New Category' }}</flux:heading>

            <div class="space-y-4">
                  <flux:input label="Image" type="file" wire:model="image" accept="image/jpeg,image/png,image/webp,image/gif" />

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="h-20 w-20 object-cover rounded border" />
                @elseif ($currentImageUrl)
                    <img src="{{ $currentImageUrl }}" class="h-20 w-20 object-cover rounded border" />
                @endif
                <flux:input label="Name" wire:model.defer="name" />
                <flux:textarea label="Description" wire:model.defer="description" rows="3" />
              
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
                <flux:modal.close>
                    <flux:button type="button" variant="ghost" wire:click="resetForm" class="cursor-pointer">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="indigo" class="cursor-pointer">Update</flux:button>
            </div>
        </form>
    </flux:modal>

        <flux:modal name="confirm-delete-modal" class="w-128">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Delete Category?</flux:heading>
                    <flux:text class="mt-2">
                       <p>You're about to delete <strong>{{ $categoryName }}</strong>. This action cannot be undone.</p>

                    </flux:text>
                </div>
                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost" class="cursor-pointer">Cancel</flux:button>
                    </flux:modal.close>
                    <flux:modal.close>
                        <flux:button wire:click="delete" variant="danger" class="cursor-pointer">
                            Delete Category
                        </flux:button>
                    </flux:modal.close>
                </div>
            </div>
        </flux:modal>
</div>
