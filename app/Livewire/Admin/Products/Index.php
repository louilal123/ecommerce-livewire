<?php

namespace App\Livewire\Admin\Products;


use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Category;
use Flux\Flux;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Url;

#[Layout('components.layouts.admin')]
class Index extends Component
{
   use WithPagination;

    public $deleteId;
    public $productName;
    public string $search = '';

     public function render()
    {
      $products = Product::with('category.parent') 
        ->when($this->search, fn ($query) =>
            $query->where('name', 'like', '%' . $this->search . '%')
        )
        ->latest()
        ->paginate(8);


        return view('livewire.admin.products.index', compact('products'));
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
}
