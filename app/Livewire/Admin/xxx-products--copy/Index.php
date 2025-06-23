<?php
namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;
    
    protected $listeners = [
        'product-created' => '$refresh',
        'product-updated' => '$refresh', 
        'product-deleted' => '$refresh'
    ];

    public function delete($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $product->delete();
            
            session()->flash('success', 'Product deleted successfully.');
            $this->dispatch('product-deleted');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $products = Product::latest()->paginate(10);
        return view('livewire.admin.products.index', compact('products'));
    }
}