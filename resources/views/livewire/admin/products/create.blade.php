<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="xl" level="1">Add New Product</flux:heading>
        <a href="{{ route('admin.products.index') }}" wire:navigate>
            <flux:button variant="filled">← Back</flux:button>
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 p-6 rounded-md border border-zinc-200 dark:border-zinc-700 space-y-6">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <label class="w-48 text-sm font-medium">Product Name</label>
                    <flux:input wire:model.defer="name" class="flex-1" />
                </div>

                <div class="flex items-center gap-4">
                    <label class="w-48 text-sm font-medium">Price</label>
                    <flux:input type="number" step="0.01" wire:model.defer="price" class="flex-1" />
                </div>

                <div class="flex items-center gap-4">
                    <label class="w-48 text-sm font-medium">Category</label>
                    <flux:select wire:model.defer="category_id" class="flex-1">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <div class="flex items-start gap-4">
                    <label class="w-48 text-sm font-medium pt-2">Description</label>
                    <flux:textarea wire:model.defer="description" rows="3" class="flex-1" />
                </div>
            </div>

            {{-- Product Attributes --}}
            @foreach ($productAttributes as $attrIndex => $attribute)
                <div class="border p-4 rounded-lg space-y-4">
                    <div class="flex items-center gap-4">
                        <label class="w-48 text-sm font-medium">Attribute Name</label>
                        <flux:input wire:model.defer="productAttributes.{{ $attrIndex }}.name" class="flex-1" />
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="w-48 text-sm">Display image per value?</label>
                        <input type="checkbox"
                            wire:model="productAttributes.{{ $attrIndex }}.shows_image"
                            wire:change="handleImageToggle({{ $attrIndex }})"
                            @disabled($imageAttributeSet && !$attribute['shows_image']) />
                    </div>

                    @foreach ($attribute['values'] as $valIndex => $value)
                        <div class="flex items-center gap-4">
                            <label class="w-48 text-sm">Value</label>
                            <flux:input
                                wire:model.defer="productAttributes.{{ $attrIndex }}.values.{{ $valIndex }}.value"
                                class="flex-1"
                            />

                            @if ($attribute['shows_image'])
                                <input type="file"
                                    wire:model="productAttributes.{{ $attrIndex }}.values.{{ $valIndex }}.image"
                                    accept="image/*"
                                    required
                                    class="ml-2 text-sm" />
                            @endif
                        </div>
                    @endforeach

                    <flux:button type="button" wire:click="addAttributeValue({{ $attrIndex }})" size="sm">+ Add Value</flux:button>
                </div>
            @endforeach

            <flux:button type="button" wire:click="addAttribute" variant="outline" color="gray">+ Add Attribute</flux:button>

            {{-- Variant Combinations --}}
            @if (count($variantCombinations))
                <div class="space-y-4 border-t pt-6 dark:border-zinc-700">
                    <h2 class="font-semibold text-lg">Variant Stocks</h2>
                    @foreach ($variantCombinations as $index => $variant)
                        <div class="flex items-center gap-4">
                            <label class="w-48 text-sm font-medium">
                                {{ implode(' / ', $variant['keys']) }}
                            </label>
                            <flux:input
                                type="number"
                                min="0"
                                wire:model.defer="variantCombinations.{{ $index }}.quantity"
                                class="w-32"
                            />
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="pt-4 border-t dark:border-zinc-700 flex gap-3">
                <flux:button type="submit" variant="primary">Save</flux:button>
                <a href="{{ route('admin.products.index') }}" wire:navigate>
                    <flux:button type="button" variant="filled">Cancel</flux:button>
                </a>
            </div>
        </form>
    </div>
</div>