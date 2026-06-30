<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('listings')->orderBy('sort_order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create', [
            'category' => new Category(['sort_order' => Category::max('sort_order') + 1]),
            'availableTabs' => config('listing_tabs.tabs'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'availableTabs' => config('listing_tabs.tabs'),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory($request, $category);

        // Keep slug stable unless the name changed and admin wants a new one.
        if ($data['name'] !== $category->name && $request->boolean('regenerate_slug')) {
            $data['slug'] = $this->uniqueSlug($data['name'], $category->id);
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->listings()->exists()) {
            return back()->with('error', 'Cannot delete a category that still has listings. Reassign them first.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }

    private function validateCategory(Request $request, ?Category $category = null): array
    {
        $togglable = array_keys(config('listing_tabs.tabs'));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'required|integer|min:0',
            'tabs' => 'nullable|array',
            'tabs.*' => Rule::in($togglable),
        ]);

        // Persist tabs in their canonical catalog order, always keeping the
        // "always" tabs (overview / reviews) present even if unchecked.
        $selected = $validated['tabs'] ?? [];
        $ordered = [];
        foreach (config('listing_tabs.tabs') as $key => $def) {
            if (($def['always'] ?? false) || in_array($key, $selected, true)) {
                $ordered[] = $key;
            }
        }
        $validated['tabs'] = $ordered;

        return $validated;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Category::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
