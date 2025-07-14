<div>
 <div class="flex items-center justify-between mb-4">
   <div class="flex items-center gap-2">
         @php
            $slugs = explode('/', $categoryPath ?? '');
            $segments = [];
            $labels = [];

            $parentId = null;
            foreach ($slugs as $slug) {
                $category = \App\Models\Category::where('slug', $slug)
                    ->where('parent_id', $parentId)
                    ->first();

                $labels[] = $category?->name ?? ucfirst(str_replace('-', ' ', $slug));
                $parentId = $category?->id;
            }
        @endphp

        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{ route('admin.categories') }}" wire:navigate>
                Home
            </flux:breadcrumbs.item>

            @foreach ($slugs as $index => $slug)
                @php
                    $segments[] = $slug;
                    $partialPath = implode('/', $segments);
                    $isLast = $index === count($slugs) - 1;
                    $label = $labels[$index];
                @endphp

                @if ($isLast)
                    <flux:breadcrumbs.item>{{ $label }}</flux:breadcrumbs.item>
                @else
                    <flux:breadcrumbs.item
                        href="{{ route('admin.category.subcategory', ['categoryPath' => $partialPath]) }}"
                        wire:navigate
                    >
                        {{ $label }}
                    </flux:breadcrumbs.item>
                @endif
            @endforeach
        </flux:breadcrumbs>

        </div>
        <flux:button wire:click="create" variant="primary" color="indigo" class="cursor-pointer" icon="plus">
            Add Category
        </flux:button>
    </div>

    <div class="mb-4">
        <flux:input.group>
            <flux:input placeholder="Search categories..." icon="magnifying-glass" class="max-w-sm" wire:model.live="search" />
            <flux:input.group.suffix>Search</flux:input.group.suffix>
        </flux:input.group>
    </div>

    <div class="overflow-hidden bg-white border rounded-lg shadow dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
            <thead class="bg-zinc-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse ($categories as $category)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="" class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center rounded text-sm text-zinc-400">No Image</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                           @php
                                $newPath = $categoryPath ? $categoryPath . '/' . $category->slug : $category->slug;
                            @endphp

                             <flux:link class="text-sm cursor-pointer"  href="{{ route('admin.category.subcategory', ['categoryPath' => $newPath]) }}" wire:navigate>
                                {{ $category->name }}
                            </flux:link>

                        </td>
                        <td class="px-6 py-4 truncate max-w-sm">{{ Str::limit($category->description, 100) }}</td>
                        <td class="px-6 py-4 flex gap-2">
                           
                            <flux:button wire:click="edit({{ $category->id }})" variant="primary" size="sm" class="cursor-pointer" color="emerald">Edit</flux:button>
                            <flux:button wire:click="confirmDelete({{ $category->id }})" size="sm" variant="danger">Delete</flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-6 py-6 text-zinc-500 dark:text-zinc-400">No subcategories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>

    <flux:modal name="category-form" class="max-w-3xl w-full">
        <form wire:submit.prevent="{{ $categoryId ? 'update' : 'save' }}" class="space-y-6" enctype="multipart/form-data">
            <flux:heading size="lg">{{ $categoryId ? 'Edit Category' : 'Add Category' }}</flux:heading>

            <div class="space-y-4">
                 <flux:input label="Image" type="file" wire:model="image" accept="image/*" />

                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="h-20 w-20 object-cover rounded border">
                @elseif ($currentImageUrl)
                    <img src="{{ $currentImageUrl }}" class="h-20 w-20 object-cover rounded border">
                @endif
                <flux:input label="Name" wire:model.defer="name" />
                <flux:textarea label="Description" wire:model.defer="description" rows="3" />
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t dark:border-zinc-700">
                <flux:modal.close>
                    <flux:button type="button" variant="ghost" wire:click="resetForm">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" color="indigo">Save</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="confirm-delete-modal" class="w-128">
        <div class="space-y-6">
            <flux:heading size="lg">Delete Category?</flux:heading>
            <flux:text class="mt-2">
                You're about to delete <strong>{{ $categoryName }}</strong>. This cannot be undone.
            </flux:text>
            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:modal.close>
                    <flux:button wire:click="delete" variant="danger">Delete</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
</div>
