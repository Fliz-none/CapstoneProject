    @foreach( $catalogues as $key => $catalogue)
    <li class="list-group-item border border-0 pb-0" id="catalogue-group-{{ $catalogue->id }}">
        <input type="checkbox" name="catalogues[]" value="{{ $catalogue->id }}" id="catalogue-{{ $catalogue->id }}" data-keyword="{{ $catalogue->name }}" class="form-check-input me-1 @error('catalogue') is-invalid @enderror" {{ (isset($product) && $product->catalogues->pluck('name')->contains($catalogue->name)) ? 'checked' : '' }}>
        <label class="form-check-label d-inline" for="catalogue-{{ $catalogue->id }}">{{ $catalogue->name }}</label>
        <ul class="list-group">
            @if(count($catalogue->children))
            @include('admin.includes.catalogue_recursion', [
            'catalogues' => $catalogue->children,
            'product' => (isset($product)) ? $product : null
            ])
            @endif
        </ul>
    </li>
    @endforeach
