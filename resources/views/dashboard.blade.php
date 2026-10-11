@extends('layouts.app')

@section('content')
<div class="container py-5">
  <div class="mb-4">
    <p class="text-muted mb-1">Welcome back</p>
    <h1 class="mb-0">Dashboard</h1>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="h5">Hello, {{ auth()->user()->name }}</h2>
      <p class="text-muted mb-0">You are signed in as {{ auth()->user()->email }}.</p>
    </div>
  </div>
</div>
@endsection
