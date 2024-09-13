<div class="package-container">
    @if (!empty($myPlan))
        <div class="package-item">
            <p class="package-main-title">
                Your Package
            </p>
            <p class="package-title"> {{ $myPlan->name }} - {{ $myPlan->currency }} {{ $myPlan->price }}</p>
            <div class="package-detail-container">
                <div class="detail row">
                    <ul class="col-md-8">
                        @foreach ($myPlan->details as $detail)
                            <li>{{ $detail->description }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @php
        $showOtherPackage = false;
    @endphp
    @foreach ($otherPlans as $plan)
        <div class="package-item mt">
            @if (!$showOtherPackage)
                <p class="package-main-title">
                    Other Package
                </p>
                @php
                    $showOtherPackage = true;
                @endphp
            @endif
            <p class="ml-4 package-title row">
                <span class="package-name col-8">{{ $plan->name }} - {{ $plan->currency }} {{ $plan->price }}</span>
                @if (auth()->check())
                    <button class="ghost-btn-primary package-select-button col-md-1 col-3"
                        onclick="window.location.href='{{ route('athletes.payment') . '?plan_id=' . $plan->priceId }}'">Select</button>
                @else
                    <button class="ghost-btn-primary package-select-button col-md-1 col-3"
                        onclick="window.location.href='{{ route('register') . '?plan_id=' . $plan->priceId }}'">Select</button>
                @endif
            </p>
            <div class="package-detail-container">
                <div class="detail row">
                    <ul class="col-md-8">
                        @foreach ($plan->details as $detail)
                            <li>{{ $detail->description }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>
