{% set cartService = app.make('App\\Services\\CartService') %}
{% set fields = cartService.prepareViewFields() %}
{% set total = fields.total|format_price %}
{% set quantity = fields.quantity %}

<span id="cart-cta" class="btn btn-outline-success my-2 my-sm-0 ml-3" href="javascript:void(0)">
    <i class="fa fa-shopping-cart"></i>
    <span id="cart-count" name="quantity" class="disabled sl-1">{{ quantity }}</span>&nbsp;&nbsp;
    <span id="cart-total" name="price" class="disabled sl-1">{{ total }}</span>
    <i class="fa fa-euro"></i>
</span>
