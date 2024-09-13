@props(['showAll' => true])
<div class="your-order-container">
    <p class="cart-title @if (count($orders) > 0) active @endif">Your Order </p>
    @if ($order_count == 0)
        <p class="no-cart">You haven’t order anything yet, Select your custom kit </p>
    @else
        <div class="table-responsive">
            <table class="table table-hover order-table">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Order Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Items</th>
                        <th scope="col">Payment</th>
                        <th scope="col">Status</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td scope="row">{{ $order->token }}</td>
                            <td>
                                Order #{{ $order->token }}
                                ({{ formatDateTime($order->created_at, 'M d Y') }})
                            </td>
                            <td>{{ formatDateTime($order->created_at, 'M d, h:i:A') }}</td>
                            <td>{{ $order->items_count }}</td>
                            <td>
                                @if (!empty($order->transaction))
                                    <span
                                        class="badge @if ($order->transaction->status == \App\Enums\TransactionStatus::PAID) badge-primary @elseif($order->transaction->status == \App\Enums\TransactionStatus::UN_PAID) badge-warning @endif">
                                        {{ strtoupper(\App\Enums\TransactionStatus::getKey((int) $order->transaction->status)) }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span
                                    class="badge @if ($order->status == \App\Enums\OrderStatus::PENDING) badge-warning @elseif($order->status == \App\Enums\OrderStatus::IN_REVIEW) badge-secondary @elseif($order->status == \App\Enums\OrderStatus::COMPLETE) badge-success @endif">
                                    {{ strtoupper(\App\Enums\OrderStatus::getKey((int) $order->status)) }}
                                </span>
                            </td>
                            <td>{{ $order->currency ?? '$' }} {{ $order->grand_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($showAll == 'true' && ((int)$order_count > (int)config('app.order_limit')))
                <a href="{{ getCurrentUserHomeUrl() . '?orderList=true' }}" class="ghost-btn-primary view-all-order">
                    {{ __('View All Orders') }}
                </a>
            @endif
        </div>
    @endif
</div>
