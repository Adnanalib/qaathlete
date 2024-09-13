<div class="w-full regular slider product-slider">
    @foreach ($items as $product)
        <div class="product-cart-container">
            <img src="{{ asset($product->cover_photo) }}" alt="{{ $product->title }}" />
            <p class="product-title" onclick="window.location.href='{{route($route_name, $product->uuid)}}'">{{ str_limit($product->title, 20, '...') }} <span class="float-right">{{ $product->currency }}
                    {{ $product->getPrice() }}</span></p>
            <p class="product-description">{{ str_limit($product->description, 150, '...') }}</p>
        </div>
    @endforeach
</div>
