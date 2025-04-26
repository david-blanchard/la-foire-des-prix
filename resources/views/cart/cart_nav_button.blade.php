@php
    use App\Utils\MiscUtils;

    $app = app();
    $cart = $app->make(\App\Services\CartService::class);
    $fields = $cart->prepareViewFields();
    $total = MiscUtils::formatPrice($fields['total']);
    $quantity = $fields['quantity'];
@endphp

<span id="cart-cta" class="btn btn-outline-success my-2 my-sm-0 ml-3" href="javascript:void(0)">
    <i class="fa fa-shopping-cart"></i>
    <span id="cart-count" name="quantity" class=" disabled sl-1">{{ $quantity }}</span>&nbsp;&nbsp;
    <span id="cart-total" name="price" class=" disabled sl-1">{{ $total }}</span>
    <i class="fa fa-euro"></i>
</span>
