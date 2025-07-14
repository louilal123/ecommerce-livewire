<div>
    <div class="flex items-center justify-between mb-2">
        <flux:heading size="xl">Manage Users</flux:heading>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-zinc-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse ($users as $user)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}"
                                    class="h-12 w-12 object-cover rounded"
                                    alt="{{ $user->name }}" />
                            @else
                                <div class="h-12 w-12 bg-zinc-100 dark:bg-zinc-800 rounded flex items-center justify-center">
                                    <span class="text-xs text-zinc-400">No Image</span>
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm  font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $user->name }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap max-w-sm truncate text-sm text-zinc-600 dark:text-zinc-400">
                            <div class="text-sm  font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $user->created_at->format('d-M-Y g:i:s A') }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <flux:button wire:click="edit({{ $user->id }})" variant="primary" size="sm" class="cursor-pointer" color="sky">
                               View
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
        {{ $users->links() }}
    </div>

    <div class="mt-2">
    Close your eyes. Count to one. That is how long forever feels.
</div>
</div>
