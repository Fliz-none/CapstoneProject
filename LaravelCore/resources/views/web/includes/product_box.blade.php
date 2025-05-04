  <div class="swiper-slide">
      <div class="product-item">
          <div class="product-slide-image">
              <a href="{{ route('shop', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                  <img class="img-fluid" src="{{ $product->getAvatarUrlAttribute() }}" alt="{{ $product->name }}">
              </a>
          </div>
          <div class="product-content text-start">
              <a class="product-name" href="{{ route('shop', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}" title="{{ $product->name }}">
                  {{ $product->name }}
              </a>
              <p class="short">Quy cách: {{ $product->unit }} </p>
              <p class="price">Giá: <span>{!! $product->displayPrice() !!}</span></p>
              <div class="d-flex justify-content-between align-items-center">
                  <div class="product-ratting">
                      <ul>
                          <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                          <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                          <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                          <li><a href="#"><i class="bi bi-star-fill"></i></i></a></li>
                          <li><a href="#"><i class="bi bi-star-half"></i></a></li>
                          {{-- <li><a href="#"><i class="bi bi-star"></i></a></li> --}}
                      </ul>
                  </div>
                  <div>
                      <a class="detail" href="{{ route('shop', ['catalogue' => $product->catalogues->first()->slug, 'slug' => $product->slug]) }}"><i class="bi bi-bag-check"></i></a>
                  </div>
              </div>
          </div>
      </div>
  </div>
