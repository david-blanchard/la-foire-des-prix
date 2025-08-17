type CartNavButtonProps = {
  quantity: number;
  total: number | string;
};

export default function CartNavButton({ quantity, total }: CartNavButtonProps) {
  return (
    <button
      id="cart-cta"
      className="btn btn-outline-success my-2 my-sm-0 ml-3"
      type="button"
    >
      <i className="fa fa-shopping-cart"></i>
      <span id="cart-count" data-ame="quantity" className="disabled sl-1">
        {quantity}
      </span>
      &nbsp;&nbsp;
      <span id="cart-total" data-name="price" className="disabled sl-1">
        {total}
      </span>
    </button>
  );
}