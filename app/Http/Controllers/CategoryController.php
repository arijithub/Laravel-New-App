<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()->latest()->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create', [
            'category' => new Category,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->validationRules());
        $validated['created_by'] = $request->user()->id;
        $validated['updated_by'] = $request->user()->id;

        $image = $request->file('image');

        if ($image instanceof UploadedFile) {
            $validated['image'] = $this->storeImage($image);
        } else {
            unset($validated['image']);
        }

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate($this->validationRules());
        $validated['updated_by'] = $request->user()->id;
        unset($validated['image']);

        $image = $request->file('image');
        $previousImage = $category->image;

        if ($image instanceof UploadedFile) {
            $validated['image'] = $this->storeImage($image);
        }

        $category->update($validated);

        if (isset($validated['image'])) {
            $this->deleteImage($previousImage);
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $image = $category->image;
        $category->delete();
        $this->deleteImage($image);

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    /**
     * @return array<string, list<string>>
     */
    private function validationRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'boolean'],
        ];
    }

    private function storeImage(UploadedFile $image): string
    {
        $path = $image->store('categories', 'public');

        if ($path === false) {
            throw new RuntimeException('Unable to store the category image.');
        }

        return $path;
    }

    private function deleteImage(?string $path): void
    {
        if ($path !== null && str_starts_with($path, 'categories/') && ! Storage::disk('public')->delete($path)) {
            throw new RuntimeException('Unable to delete the category image.');
        }
    }
}
