<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $products = Product::query()
            ->when($this->search, fn ($query) =>
                $query->where('name', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(12);

        return view('livewire.productlist', [
            'products' => $products,
        ]);
    }
}
