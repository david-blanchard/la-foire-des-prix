@php
    use App\Utils\MiscUtils;
    $hasDiscount = $discount > 0 && $discount < $price;
    $priceTag = $hasDiscount ? $discount : $price;

    $priceTag = MiscUtils::formatPrice($priceTag);
    $basePrice = MiscUtils::formatPrice($price);
@endphp

<div class="row mx-1">
    <div id="product" name="product-data" data-id="{{ $id }}">
        <h4 class='featurette-heading'>
            {{ $name }}
        </h4>
    </div>
</div>
<div class="row justify-content-between mx-1">
    <div>
        <h5 class='featurette-heading'>
            {{ $brand }}
        </h5>
    </div>
    <div>
        @if($hasDiscount)
            <h6 id="stroke-price-tag" name="unit-price" class="btn-outline-danger disabled">
                <del>{{ $basePrice }} <i class="fa fa-euro"></i></del>
            </h6>
        @endif
        <h3 id="price-tag" name="unit-price" data-discount-rate="{{ $discountRate }}"
            class="btn-outline-success disabled">
            {{ $priceTag }}&nbsp;<i class="fa fa-euro"></i>
        </h3>
    </div>
</div>
