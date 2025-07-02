@foreach ($catalogues as $key => $cat)
    <li class="list-group-item border-0 pb-0" id="catalogue-group-{{ $cat->id }}">
        <input type="radio" name="catalogue_slug" value="{{ $cat->slug }}" id="catalogue-{{ $cat->id }}"
            class="catalogue-radio" {{ request('catalogue_slug') == $cat->slug ? 'checked' : '' }}>
        <label for="catalogue-{{ $cat->id }}" class="catalogue-label d-flex align-items-center">
            <img src="{{ $cat->avatarUrl }}" class="w-25 me-2" alt="{{ $cat->name }}"> 
            {{ $cat->name }}
        </label>

        <ul class="list-group ms-3">
            @if (count($cat->children) && ($is_recursion ?? false))
                @include('web.includes.catalogue_recursion', [
                    'catalogues' => $cat->children,
                    'product' => $product ?? null,
                ])
            @endif
        </ul>
    </li>
@endforeach
