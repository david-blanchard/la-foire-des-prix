import React, { useEffect, useState } from 'react';
import { CartData, CartProps, useCartManager } from '../../Service/CartManager';

export const CartManagerService: React.FC<CartProps> = ({ productId }) => {
  const [cart, setCart] = useState<CartData>({ quantity: 0, total: 0 });

  const store = useCartManager().store;
  const retrieve = useCartManager().retrieve;

  useEffect(() => {
    retrieve((data: CartData) => {
      setCart(data);
    });
  }, []);

  return (
    <div>
      <span id="cart-cta">
        <span id="cart-count" data-name="quantity">
          {cart.quantity}
        </span>
        <span id="cart-total" data-name="price">
          {cart.total.toFixed(2).replace('.', ',')}
        </span>
      </span>
      {productId && (
        <button
          onClick={() =>
            store(productId, 1, (data: CartData) => {
              setCart(data);
            })
          }
        >
          Ajouter au panier
        </button>
      )}
    </div>
  );
};
