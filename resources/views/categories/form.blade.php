<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input
        type="text"
        id="name"
        name="name"
        value="{{ old('name', $category->name) }}"
        class="form-control @error('name') is-invalid @enderror"
        maxlength="255"
        required
    >
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea
        id="description"
        name="description"
        class="form-control @error('description') is-invalid @enderror"
        maxlength="255"
        rows="3"
    >{{ old('description', $category->description) }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if ($category->image)
    <div class="mb-3">
        <p class="form-label">Current image</p>
        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 200px;">
    </div>
@endif

<div class="mb-3">
    <label for="image" class="form-label">{{ $category->image ? 'Replace image' : 'Image' }}</label>
    <input
        type="file"
        id="image"
        name="image"
        class="form-control @error('image') is-invalid @enderror"
        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
    >
    <div class="form-text">JPG, PNG, or WebP; maximum size 2 MB. Leave empty to keep the current image.</div>
    @error('image')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
        <option value="1" @selected((string) old('status', (int) $category->status) === '1')>Active</option>
        <option value="0" @selected((string) old('status', (int) $category->status) === '0')>Inactive</option>
    </select>
    @error('status')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
