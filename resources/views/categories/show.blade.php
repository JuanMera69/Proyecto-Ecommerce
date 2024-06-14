@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <div class="row">
        @forelse($category->products as $product)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if($product->image && file_exists(public_path('images/' . $product->image)))
                        <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/productos_por_defecto.jpg') }}" class="card-img-top" alt="Imagen del producto">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text"><strong>Precio:</strong> ${{ $product->price }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Ver Producto</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <p>No hay productos disponibles en esta categoría.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection