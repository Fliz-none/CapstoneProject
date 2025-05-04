    @foreach( $catalogues as $key => $cat)
    <li class="list-group-item border border-0 pb-0" id="catalogue-group-{{ $cat->id }}">
        <input type="checkbox" name="catalogues[]" value="{{ $cat->id }}" id="catalogue-{{ $cat->id }}" class="form-check-input me-1"{{ isset($catalogue) && $catalogue->id == $cat->id ? 'checked' : '' }} >
         {{-- {{ ($cat->id == $catalogue->id) ? 'checked' : '' }}  --}}
        <label class="form-check-label" for="catalogue-{{ $cat->id }}">{{ $cat->name }}</label>
        {{-- <ul class="list-group">
            @if(count($cat->children))
            @include('web.includes.catalogue_recursion', [
            'catalogues' => $cat->children,
            'product' => (isset($product)) ? $product : null
            ])
            @endif
        </ul> --}}
    </li>
    @endforeach
