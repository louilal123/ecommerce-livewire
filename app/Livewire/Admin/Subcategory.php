<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Flux\Flux;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Subcategory extends Component
{
    use WithPagination, WithFileUploads;

    public ?string $categoryPath = null;
    public $parentCategory = null;
    public string $breadcrumb = '';
    public string $search = '';

    public $name;
    public $description;
    public $image;
    public $categoryId;
    public $currentImageUrl;

    public $deleteId;
    public $categoryName;

    public function mount($categoryPath = null)
    {
        $this->categoryPath = $categoryPath;

        if ($categoryPath) {
            $slugs = explode('/', $categoryPath);
            $this->parentCategory = $this->resolveCategoryPath($slugs);
        }

        $this->updateBreadcrumb();
    }

    public function resolveCategoryPath($slugs)
    {
        $parent = null;
        foreach ($slugs as $slug) {
            $parent = Category::where('slug', $slug)
                ->where('parent_id', $parent?->id)
                ->firstOrFail();
        }
        return $parent;
    }

    public function updateBreadcrumb()
    {
        $trail = [];
        $cat = $this->parentCategory;
        while ($cat) {
            $trail[] = $cat->name;
            $cat = $cat->parent;
        }
        $this->breadcrumb = implode(' / ', array_reverse($trail));
    }

    public function getBreadcrumbLabelsProperty()
    {
        return explode(' / ', $this->breadcrumb);
    }

    public function getCategoriesProperty()
    {
        return Category::query()
            ->where('parent_id', $this->parentCategory?->id)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate(10);
    }

    public function create()
    {
        $this->resetForm();
        Flux::modal('category-form')->show();
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        $imagePath = $this->image ? $this->image->store('category', 'public') : null;

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'image' => $imagePath,
            'parent_id' => $this->parentCategory?->id,
            'level' => $this->parentCategory?->level + 1 ?? 1,
        ]);

        $this->resetForm();
        Flux::modal('category-form')->close();

        $this->redirectRoute('admin.category.subcategory', [
            'categoryPath' => $this->categoryPath
        ], navigate: true);
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
        $category = Category::findOrFail($this->categoryId);

        $validated = $this->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:1024',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'slug' => Str::slug($validated['name']),
        ];

        if ($this->image) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $updateData['image'] = $this->image->store('category', 'public');
        }

        $category->update($updateData);

        $this->resetForm();
        Flux::modal('category-form')->close();

        $this->redirectRoute('admin.category.subcategory', [
            'categoryPath' => $this->categoryPath
        ], navigate: true);
    }

    public function confirmDelete($id)
    {
        $cat = Category::findOrFail($id);
        $this->deleteId = $cat->id;
        $this->categoryName = $cat->name;
        Flux::modal('confirm-delete-modal')->show();
    }

public function delete()
{
    $category = Category::findOrFail($this->deleteId);

    if ($category->products()->exists()) {
        $this->redirectRoute('admin.category.subcategory', [
            'categoryPath' => $this->categoryPath
        ], navigate: true);
        return;
    }

    if ($category->children()->exists()) {
        $this->redirectRoute('admin.category.subcategory', [
            'categoryPath' => $this->categoryPath
        ], navigate: true);
        return;
    }

    $imagePath = $category->image;

    $category->delete();

    if ($imagePath) {
        Storage::disk('public')->delete($imagePath);
    }


    $this->redirectRoute('admin.category.subcategory', [
        'categoryPath' => $this->categoryPath
    ], navigate: true);
}


    public function resetForm()
    {
        $this->reset(['name', 'description', 'image', 'categoryId', 'currentImageUrl']);
    }

    public function render()
    {
        return view('livewire.admin.subcategory', [
            'categories' => $this->categories,
            'breadcrumbLabels' => $this->breadcrumbLabels,
        ]);
    }
}
