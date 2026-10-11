@extends('layouts.app')

@section('content')
<main class="container py-5">
    <h1 class="mb-4">Add category</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('categories.form')
                <button type="submit" class="btn btn-primary">Create category</button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</main>
@endsection
