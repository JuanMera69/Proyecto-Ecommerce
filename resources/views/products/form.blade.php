<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}"
        required>
</div>
<div class="form-group">
    <label for="description">Descripción</label>
    <textarea class="form-control" id="description" name="description" required>{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div class="form-group">
    <label for="price">Precio</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">$</span>
        </div>
        <input type="number" class="form-control" id="price" name="price"
            value="{{ old('price', $product->price ?? '') }}" required>
    </div>
</div>
<div class="form-group">
    <label for="stock">Stock</label>
    <input type="number" class="form-control" id="stock" name="stock"
        value="{{ old('stock', $product->stock ?? '') }}" required>
</div>
<div class="form-group">
    <label for="category_id">Categoría</label>
    <select class="form-control" id="category_id" name="category_id" required>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="image">Imagen</label>
    <input type="file" class="form-control-file" id="image" name="image">
    <small class="form-text text-muted">Sube una imagen del producto (opcional).</small>
</div>
