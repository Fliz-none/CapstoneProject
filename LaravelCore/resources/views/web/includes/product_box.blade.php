@if ($product->catalogues->first())
    <div class="swiper-slide">
        <div class="product-item">
            <div class="product-slide-image">
                <a href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                    <img class="img-fluid" src="{{ $product->getAvatarUrlAttribute() }}" alt="{{ $product->name }}">
                </a>
            </div>
            <div class="product-content text-start">
                <a class="product-name" href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                    {{ $product->name }}
                </a>
                <p class="short">{{ $product->variables->pluck('name')->take(3)->implode(', ') }}{{ $product->variables->count() > 3 ? '...' : '' }} </p>
                <p class="price"><span>{!! $product->displayPrice() !!}</span></p>
                <div class="d-flex justify-content-between align-items-center">
                    @php
                        $rating = $product->star ?? 0;
                        $fullStars = floor($rating);
                        $halfStar = $rating - $fullStars >= 0.25 && $rating - $fullStars < 0.75;
                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                    @endphp
                    <div class="product-ratting">
                        <ul class="d-flex" style="gap: 3px; padding-left: 0; margin: 0; list-style: none;">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <li><i class="bi bi-star-fill text-warning"></i></li>
                            @endfor

                            @if ($halfStar)
                                <li><i class="bi bi-star-half text-warning"></i></li>
                            @endif

                            @for ($i = 0; $i < $emptyStars; $i++)
                                <li><i class="bi bi-star text-warning"></i></li>
                            @endfor
                        </ul>
                    </div>
                    <div>
                        <a class="detail" href="{{ route('product', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}"><i class="bi bi-bag-check"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
