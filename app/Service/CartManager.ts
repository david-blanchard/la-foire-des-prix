import { useServerSession } from './ServerSession';

interface CartData {
  quantity: number;
  total: number;
}

interface CartProps {
  productId?: number;
}

class CartManager {
  private session = useServerSession('/cart');

  retrieve(callback: (data: CartData) => void) {
    this.session.retrieve({ type: 'Cart' }, callback);
  }

  store(
    productId: number,
    quantity: number,
    callback: (data: CartData) => void
  ) {
    this.session.store(
      {
        type: 'Cart',
        content: [{ productId, quantity }],
      },
      callback
    );
  }
}

function useCartManager() {
  return new CartManager();
}

export type { CartData, CartProps };
export { useCartManager };
