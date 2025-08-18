import { useState } from 'react';
import { CartData, useCartManager } from '../../Service/CartManager';

export default function Quantity() {
  const [quantity, setQuantity] = useState(1);
  const [productId, setProductId] = useState(1);
  const cartManager = useCartManager();

  const handleLess = () => {
    if (quantity > 1) setQuantity(quantity - 1);
  };

  const handleMore = () => {
    setQuantity(quantity + 1);
  };

  const handleAddToCart = () => {
    // Logic to add the product to the cart with the current quantity
    console.log(`Adding ${quantity} items to the cart`);
    // Here you would typically call a function to update the cart state
    cartManager.store(productId, quantity, (data: CartData) => {
      console.log(`Cart updated: ${data.quantity} items, total: ${data.total}`);
    });
  };

  return (
    <div className="row justify-content-between mx-1 my-2">
      <div>
        <ul className="pagination">
          <li className="page-item disabled">
            <span className="page-link" tabIndex={-1} aria-disabled="true">
              Quantité
            </span>
          </li>
          <li className={`page-item${quantity === 1 ? ' disabled' : ''}`}>
            <button
              id="less"
              data-name="quantity-handler"
              className="page-link"
              onClick={handleLess}
              disabled={quantity === 1}
              type="button"
            >
              -
            </button>
          </li>
          <li className="page-item disabled">
            <span id="quantity" data-name="count" className="page-link">
              {quantity}
            </span>
          </li>
          <li className="page-item">
            <button
              id="more"
              data-name="quantity-handler"
              className="page-link"
              onClick={handleMore}
              type="button"
            >
              +
            </button>
          </li>
        </ul>
      </div>
      <div>
        <button
          id="add-to-cart"
          type="button"
          className="btn btn-outline-primary"
          onClick={handleAddToCart}
          data-name="add-to-cart"
          aria-label="Ajouter au panier"
          data-toggle="button"
        >
          Ajouter au panier
        </button>
      </div>
    </div>
  );
}
