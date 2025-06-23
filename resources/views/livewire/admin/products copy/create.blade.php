<flux:modal name="create-product" class="w-full max-w-3xl">
    <div wire:loading wire:target="save" class="text-center py-8">
        <svg class="animate-spin h-8 w-8 mx-auto mb-4" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Saving product...
    </div>
    
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-6">
        <div>
            <flux:heading size="lg">Add New Product</flux:heading>
            <flux:subheading class="mt-2">Fill in the product details below.</flux:subheading>
        </div>

        <div class="space-y-4">
            <flux:input label="Product Name" wire:model="name" required />
            <flux:textarea label="Description" wire:model="description" rows="3" />
            <flux:input label="Price" type="number" step="0.01" wire:model="price" required />
            <flux:input label="Stock Quantity" type="number" min="0" wire:model="stock" required />
            <flux:input label="Image" type="file" wire:model="image" accept="image/*" />
            
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="h-20 w-20 object-cover rounded-lg border" alt="Preview" />
            @endif
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t">
            <flux:modal.close>
                <flux:button type="button" variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <flux:button type="submit" variant="primary">Create Product</flux:button>
        </div>
    </form>
</flux:modal>