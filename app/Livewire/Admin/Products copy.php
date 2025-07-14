<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Category;
use Flux\Flux;
use Livewire\Attributes\Url;

#[Layout('components.layouts.admin')]
class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name;
    public $description;
    public $price;
    public $stock = 0;
    public $image;
    public $productId;
    public $newImage;
    public $currentImageUrl;

    public string $search = '';

    public $category_id;
    public $categories = [];

    public $deleteId;
    public $productName;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($this->productId)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => $this->productId
                ? 'nullable|mimes:jpg,jpeg,png,webp,gif|max:1024'
                : 'required|mimes:jpg,jpeg,png,webp,gif|max:1024',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function create()
    {
        $this->resetForm();
        Flux::modal('product-form')->show();
    }

    public function save()
    {
        $validated = $this->validate();
        $imagePath = $this->image ? $this->image->store('products', 'public') : null;

        Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
            'category_id' => $validated['category_id'],
        ]);

        $this->resetForm();
        Flux::modal('product-form')->close();
      
        $this->redirectRoute('admin.products', navigate: true);
    }

    public function edit($id)
    {
        $this->resetForm();
        $this->productId = $id;
        $product = Product::findOrFail($id);

        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;

        $this->currentImageUrl = $product->image
            ? asset('storage/' . $product->image)
            : null;

        $this->image = null;
        Flux::modal('product-form')->show();
    }

    public function update()
    {
        try {
            $validated = $this->validate();
            $product = Product::findOrFail($this->productId);

            if ($this->image) {
                if ($product->image) {
                    Storage::delete('public/' . $product->image);
                }
                $validated['image'] = $this->image->store('products', 'public');
            } else {
                $validated['image'] = $product->image;
            }

            $product->update($validated);
            $this->resetForm();
            Flux::modal('product-form')->close();
            $this->redirectRoute('admin.products', navigate: true);

        } catch (\Throwable $e) {
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }

    public function removeImage()
    {
        $product = Product::findOrFail($this->productId);
        if ($product->image) {
            Storage::delete('public/' . $product->image);
            $product->update(['image' => null]);
            $this->currentImageUrl = null;
            $this->image = null;
        }
    }

    public function confirmDelete($id)
    {
        $product = Product::findOrFail($id);
        $this->deleteId = $id;
        $this->productName = $product->name;
        Flux::modal('confirm-delete-modal')->show();
    }

   public function delete()
    {
        try {
            $product = Product::findOrFail($this->deleteId);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            $this->resetForm();
            $this->deleteId = null;

            $this->redirectRoute('admin.products', navigate: true);

        } catch (\Exception $e) {
           
        }
    }


    public function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'price',
            'stock',
            'image',
            'category_id',
            'productId',
            'currentImageUrl'
        ]);
        
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

        $products = Product::query()
            ->when($this->search, fn ($query) =>
                $query->where('name', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(8);

        return view('livewire.admin.products', compact('products'));
    }
}