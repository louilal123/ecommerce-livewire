<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Variant;
use App\Models\VariantValue;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use SweetAlert2\Laravel\Swal;

#[Layout('components.layouts.admin')]
class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $category_id;
    public $categories = [];

    public $productAttributes = []; // [{ name, shows_image, values: [{ value, image }] }]
    public $imageAttributeSet = false;

    public $variantCombinations = []; // [{ keys: ['Red', 'M'], quantity: 0 }]

    public function mount()
    {
        $this->categories = Category::select('id', 'name')->orderBy('name')->get();
        $this->addAttribute();
    }

    public function addAttribute()
    {
        $this->productAttributes[] = [
            'name' => '',
            'shows_image' => false,
            'values' => [
                ['value' => '', 'image' => null],
            ],
        ];
        $this->generateCombinations();
    }

    public function addAttributeValue($index)
    {
        $this->productAttributes[$index]['values'][] = ['value' => '', 'image' => null];
        $this->generateCombinations();
    }

    public function handleImageToggle($index)
    {
        foreach ($this->productAttributes as $i => &$attribute) {
            if ($i != $index) {
                $attribute['shows_image'] = false;
            }
        }
        $this->imageAttributeSet = $this->productAttributes[$index]['shows_image'];
    }

    public function generateCombinations()
    {
        $attributeValues = collect($this->productAttributes)
            ->map(fn ($attr) => collect($attr['values'])->pluck('value')->filter()->values())
            ->filter(fn ($values) => $values->isNotEmpty())
            ->toArray();

        if (count($attributeValues) === 0) {
            $this->variantCombinations = [];
            return;
        }

        $combinations = $this->cartesianProduct($attributeValues);
        $this->variantCombinations = collect($combinations)->map(fn ($combo) => [
            'keys' => $combo,
            'quantity' => 0,
        ])->toArray();
    }

    public function cartesianProduct($arrays)
    {
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property_value]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    public function updated($property)
    {
        if (Str::startsWith($property, 'productAttributes')) {
            $this->generateCombinations();
        }
    }

public function save()
{
    $this->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
    ]);

    $product = Product::create([
        'name' => $this->name,
        'description' => $this->description,
        'price' => $this->price,
        'category_id' => $this->category_id,
    ]);

    $valueMap = [];

    foreach ($this->productAttributes as $attributeData) {
        $attribute = Attribute::create([
            'product_id' => $product->id,
            'name' => $attributeData['name'],
            'shows_image' => $attributeData['shows_image'],
        ]);

        foreach ($attributeData['values'] as $valueData) {
            $imagePath = null;

            if ($attributeData['shows_image'] && isset($valueData['image'])) {
                $imagePath = $valueData['image']->store('attribute-values', 'public');
            }

            $value = AttributeValue::create([
                'attribute_id' => $attribute->id,
                'value' => $valueData['value'],
                'image' => $imagePath,
            ]);

            $valueMap[$value->value] = $value->id;
        }
    }

    foreach ($this->variantCombinations as $index => $variantData) {
        $variant = Variant::create([
            'product_id' => $product->id,
            'quantity' => $variantData['quantity'],
            'default' => $index === 0,
        ]);

        foreach ($variantData['keys'] as $value) {
            VariantValue::create([
                'variant_id' => $variant->id,
                'value_id' => $valueMap[$value] ?? null,
            ]);
        }
    }

    Swal::fire([
        'title' => 'Product added successfully!',
        'icon' => 'success',
        'toast' => true,
        'position' => 'top-end',
        'showConfirmButton' => false,
        'timer' => 3000,
    ]);

    return redirect()->route('admin.products.index');
}
    
       private function flattenedCategories()
    {
        $all = Category::orderBy('name')->get();
        $flattened = [];

        $build = function ($parentId = null, $prefix = '') use (&$build, &$all, &$flattened) {
            foreach ($all->where('parent_id', $parentId) as $category) {
                $flattened[] = [
                    'id' => $category->id,
                    'name' => $prefix . $category->name,
                ];
                $build($category->id, $prefix . '— ');
            }
        };

        $build();
        return $flattened;
    }

    public function render()
    {   
         $this->categories = $this->flattenedCategories();
        return view('livewire.admin.products.create');
    }
}