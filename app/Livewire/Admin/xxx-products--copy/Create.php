<?php
namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use Flux\Flux;

class Create extends Component
{
    use WithFileUploads;
    
    public $name = '';
    public $description = '';
    public $price = 0;
    public $stock = 0;
    public $image = null;

    protected $rules = [
        'name' => 'required|string|max:255|unique:products,name',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|max:2048',
    ];

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
        ]);

        $this->reset();
        $this->dispatch('product-created');
        
        $this->dispatch('close-modal', 'create-product');
        Flux::modal('create-product')->close(); 
        session()->flash('success', 'Product created successfully.');
    }

    public function render()
    {
        return view('livewire.admin.products.create');
    }
}