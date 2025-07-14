<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Productdetail extends Component
{
    public Product $product;
    public $selectedAttributeValues = [];
    public $currentVariant;
    public $mainImage;
    public $allProductImages = [];
    public $quantity = 1;

    public $productAttributes = [];

    public function mount(Product $product)
    {
        $this->product = $product->load([
            'variants.values.attribute',
        ]);

        $this->loadProductAttributes();
        $this->loadAllProductImages();

        $this->currentVariant = $this->product->variants->firstWhere('default', true) ?? $this->product->variants->first();

        if ($this->currentVariant) {
            foreach ($this->currentVariant->values as $value) {
                $this->selectedAttributeValues[$value->attribute->id] = $value->id;
            }
            $this->updateVariantDetails();
        } else {
            $this->mainImage = $this->allProductImages->first()?->image;
        }
    }

    public function loadProductAttributes()
    {
        $grouped = [];

        foreach ($this->product->variants as $variant) {
            foreach ($variant->values as $value) {
                $attribute = $value->attribute;
                if (!$attribute) continue;

                $attributeId = $attribute->id;

                if (!isset($grouped[$attributeId])) {
                    $grouped[$attributeId] = [
                        'name' => $attribute->name,
                            'shows_image' => $attribute->shows_image,
                        'values' => collect(),
                    ];
                }

                if (!$grouped[$attributeId]['values']->contains('id', $value->id)) {
                    $grouped[$attributeId]['values']->push($value);
                }
            }
        }

        $this->productAttributes = $grouped;
    }

    public function loadAllProductImages()
    {
        $images = collect();

        foreach ($this->product->variants as $variant) {
            foreach ($variant->values as $value) {
                $attribute = $value->attribute;
                if ($attribute && $attribute->shows_image && $value->image) {
                    if (!$images->contains('image', $value->image)) {
                        $images->push($value);
                    }
                }
            }
        }

        $this->allProductImages = $images;
    }

    public function updatedSelectedAttributeValues()
    {
        $this->findMatchingVariant();
        $this->updateVariantDetails();
    }

    protected function findMatchingVariant()
    {
        $this->currentVariant = null;

        foreach ($this->product->variants as $variant) {
            $variantValueIds = $variant->values->pluck('id')->toArray();
            $selectedValueIds = array_values($this->selectedAttributeValues);

            if (count($selectedValueIds) && empty(array_diff($selectedValueIds, $variantValueIds))) {
                $this->currentVariant = $variant;
                break;
            }
        }
    }

    protected function updateVariantDetails()
    {
        $this->mainImage = null;

        if ($this->currentVariant) {
            $imageValue = $this->currentVariant->values
                ->first(fn($val) => $val->attribute && $val->attribute->shows_image && $val->image);

            $this->mainImage = $imageValue?->image ?? $this->allProductImages->first()?->image;
        } else {
            $this->mainImage = $this->allProductImages->first()?->image;
        }
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.productdetail');
    }
}
