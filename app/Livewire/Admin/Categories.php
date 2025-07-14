<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use App\Models\Product;

#[Layout('components.layouts.admin')]
class Categories extends Component
{
    use WithPagination, WithFileUploads;
    
    public $name;
    public $description;
    public $categoryId;
    public $image;
    public $currentImageUrl;

    public string $search = '';

    public $deleteId;
    public $categoryName;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($this->categoryId)],
            'description' => 'nullable|string|max:1000',
             'image' => $this->categoryId
                ? 'nullable|mimes:jpg,jpeg,png,webp,gif|max:1024'
                : 'required|mimes:jpg,jpeg,png,webp,gif|max:1024',
        ];
    }

    public function create(){
        $this->resetForm();
        Flux::modal('category-form')->show();
    }

    public function save()
    {
        $validated = $this->validate();

        $imagePath = $this->image ? $this->image->store('category', 'public') : null;

        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image' => $imagePath,
        ]);

        $this->resetForm();
        Flux::modal('category-form')->close();
       
        $this->redirectRoute('admin.categories', navigate: true);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);

        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->currentImageUrl = $category->image ? asset('storage/' . $category->image) : null;

        Flux::modal('category-form')->show();
    }

    public function update()
    {
        $validated = $this->validate();

        $category = Category::findOrFail($this->categoryId);

        if ($this->image) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $this->image->store('category', 'public');
        } else {
            $validated['image'] = $category->image;
        }

        $category->update($validated);

        $this->resetForm();
        Flux::modal('category-form')->close();
       
        $this->redirectRoute('admin.categories', navigate: true);
    }

     public function confirmDelete($id)
    {
         $category = Category::findOrFail($id);
        $this->deleteId = $id;
        $this->categoryName = $category->name;
        Flux::modal('confirm-delete-modal')->show();
    }

    public function delete($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->products()->exists()) {
                session()->flash('error', 'Cannot delete category: Products are assigned to it.');
                $this->dispatch('close-modal', 'delete-category-' . $id);
                return;
            }

            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();
            $this->resetForm();

           
            $this->dispatch('close-modal', 'delete-category-' . $id);
            $this->redirectRoute('admin.categories', navigate: true);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete category: ' . $e->getMessage());
            $this->redirectRoute('admin.categories', navigate: true);
        }
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'image',
            'categoryId',
            'currentImageUrl'
        ]);
        $this->resetPage();
    }
    public function render()
    {
        $categories = Category::query()
            ->whereNull('parent_id')
            ->when($this->search, fn ($query) =>
                $query->where('name', 'like', '%' . $this->search . '%')
            )
            ->latest()
            ->paginate(8);

        return view('livewire.admin.categories', compact('categories'));
    }

}
