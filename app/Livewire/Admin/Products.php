<?php
namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use Livewire\Attributes\Url;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    protected $listeners = [
        'product-created' => '$refresh', 
        'product-updated' => '$refresh', 
        'product-deleted' => '$refresh'
    ];
   
    public $name;
    public $description;
    public $price;
    public $stock = 0;
    public $image;
  
    public $productId;
    public $newImage;
    public $currentImageUrl;
               
    public string $search ='';
    
   protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($this->productId)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => $this->productId ? 'nullable|image|max:2048' : 'required|image|max:2048',

        ];
    } 
    public function mount()
    {
        $this->resetPage(); 
    }
   public function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'price',
            'stock',
            'image',
            'productId',
            'currentImageUrl',
        ]);
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
        ]);

        $this->reset();
        $this->dispatch('product-created'); 
        $this->dispatch('close-modal', 'create-product');
        session()->flash('success', 'Product created successfully.');
      
        $this->redirectRoute('admin.products', navigate: true);
          $this->resetForm();
    }

    public function edit($id)
    {
        $this->productId = $id;
      
        $product = Product::findOrFail($id);
        
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

            $this->reset(['image']);
            $this->currentImageUrl = $product->fresh()->image 
                ? asset('storage/' . $product->fresh()->image)
                : null;

            $this->dispatch('close-modal', 'edit-product');
            session()->flash('success', 'Product updated successfully.');
            $this->dispatch('product-updated');
            
            $this->redirectRoute('admin.products', navigate: true);
             $this->resetForm();

        } catch (\Throwable $e) {
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }


    public function removeImage()
    {
        $product = Product::findOrFail($this->productId);
        if ($product->image) {
            Storage::delete('public/'.$product->image);
            $product->update(['image' => null]);
            $this->currentImageUrl = null;
            $this->image = null;
        }
    }

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
        $products = Product::query()
        ->when($this->search, function ($query) {
            $term = '%' . $this->search . '%';
            $query->where('name', 'like', $term)
                ->orWhere('description', 'like', $term);
        })
        ->latest()
        ->paginate(8);


        return view('livewire.admin.products', compact('products'));
    }
}