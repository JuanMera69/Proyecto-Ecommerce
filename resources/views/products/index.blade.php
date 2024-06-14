@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                @can('create products')
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createProductModal">Crear
                        Producto</button>
                @endcan
            </div>
        </div>

        <table id="productsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image && file_exists(public_path('images/' . $product->image)))
                                <img src="{{ asset('images/' . $product->image) }}" class="img-fluid"
                                    style="max-height: 100px;" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/productos_por_defecto.jpg') }}" class="img-fluid"
                                    style="max-height: 100px;" alt="Imagen por defecto">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->category ? $product->category->name : 'Sin categoría' }}</td>

                        <td>
                            <div class="btn-group" role="group" aria-label="Acciones">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Ver</a>
                                @can('edit products')
                                    <button type="button" class="btn btn-warning edit-product-btn"
                                        data-product-id="{{ $product->id }}">Editar</button>
                                @endcan
                                
                                @can('delete products')
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>

                    <!-- Modal de Edición de Producto -->
                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1"
                        aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Editar Producto
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('products.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        @include('products.form', ['product' => $product])
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal de Creación de Producto -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Crear Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @include('products.form', ['product' => null])
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                }
            });

            // Función para abrir el modal de edición al hacer clic en el botón "Editar"
            $('.edit-product-btn').on('click', function() {
                var productId = $(this).data('product-id');
                $('#editProductModal' + productId).modal('show');
            });
        });
    </script>
@endpush
