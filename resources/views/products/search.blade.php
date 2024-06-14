@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resultados de Búsqueda para "{{ $query }}"</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">{{ $product->name }}</div>
                    <div class="card-body">
                        @if($product->image)
                            <img src="{{ asset('images/' . $product->image) }}" class="img-fluid mb-3" alt="{{ $product->name }}">
                        @endif
                        <p>{{ $product->description }}</p>
                        <p>Precio: ${{ $product->price }}</p>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
