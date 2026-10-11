@extends('layouts.app')

@section('content')
<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ $category->name }}</h1>
        <div>
            <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Back to categories</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ $category->description ?: '—' }}</dd>

                <dt class="col-sm-3">Image</dt>
                <dd class="col-sm-9">
                    @if ($category->image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 300px;">
                    @else
                        —
                    @endif
                </dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">{{ $category->status ? 'Active' : 'Inactive' }}</dd>
            </dl>
        </div>
    </div>
</main>
@endsection
