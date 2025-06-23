<?php
namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

use Flux\Flux;

class Edit extends Component
{
    use WithFileUploads;

    public $productId;
    public $name = '';
    public $description = '';
    public $price = 0;
    public $stock = 0;
    public $image = null;
    public $currentImageUrl = null;

    #[On('edit-product')]
    public function loadProduct($id)
    {
        $product = Product::findOrFail($id);
        
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->currentImageUrl = $product->image 
            ? asset('storage/'.$product->image) 
            : null;
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')->ignore($this->productId)
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($this->productId);
        
        if ($this->image) {
            if ($product->image) {
                Storage::delete('public/'.$product->image);
            }
            $validated['image'] = $this->image->store('products', 'public');
        } else {
            $validated['image'] = $product->image;
        }

        $product->update($validated);
        
        $this->reset(['image']);
        $this->currentImageUrl = $product->fresh()->image 
            ? asset('storage/'.$product->fresh()->image) 
            : null;
        
        $this->dispatch('close-modal', 'edit-product');
          Flux::modal('edit-product')->close(); 
        session()->flash('success', 'Product updated successfully.');
        $this->dispatch('product-updated');
    }

    public function removeImage()
    {
        $product = Product::findOrFail($this->productId);
        if ($product->image) {
            Storage::delete('public/'.$product->image);
            $product->update(['image' => null]);
            $this->currentImageUrl = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.products.edit');
    }
}