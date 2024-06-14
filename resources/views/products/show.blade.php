@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">{{ $product->name }}</div>
                <div class="card-body">
                    @if($product->image)
                     <img src="{{ asset('images/' . $product->image) }}" class="img-fluid mb-3" alt="{{ $product->name }}" style="max-height: 200px;">
                    @else
                     <img src="{{ asset('images/productos_por_defecto.jpg') }}" class="img-fluid mb-3" alt="Imagen por defecto" style="max-width: 200px; max-height: 200px;">
                    @endif

                    <p>{{ $product->description }}</p>
                    <p>Precio: ${{ $product->price }}</p>
                    <p>Stock: {{ $product->stock }}</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
