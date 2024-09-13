@props(['route_name' => 'athlete.product.detail'])
<div class="cart-list-container">
    <p class="title">Custom Sports Kit</p>
    <p class="description">Explore products</p>
    @foreach ($products as $key => $items)
        <p class="category-title">{{ $key }}</p>
        @include('athletes.dashboard.list', compact('items', 'route_name'))
    @endforeach
</div>
