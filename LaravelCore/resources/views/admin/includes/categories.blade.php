@php
    $categories = cache()->get('categories')->whereNull('parent_id');
@endphp
@foreach ($categories as $key => $category)
    <li class="list-group-item border border-0" id="category-group-{{ $category->id }}">
        <input class="form-check-input me-1 @error('category') is-invalid @enderror" id="category-{{ $category->id }}"
            name="category_id" type="radio" value="{{ $category->id }}"
            {{ isset($selected_id) && $selected_id == $category->id ? 'checked' : '' }}>
        <label class="form-check-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
    </li>
@endforeach
