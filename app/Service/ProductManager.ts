import { ProductViewProperties } from '../Dto/ProductViewProperties';
import { CartData } from './CartManager';
import { useServerSession } from './ServerSession';
import { ProductOutput } from '../Dto/ProductOutput';

interface ProductData {
  viewProperties: ProductViewProperties;
  cartFields: CartData;
}

class ProductManager {
  private session = useServerSession('/product');
  private productId: number;

  constructor(productId: number) {
    this.productId = productId;
  }

  retrieve(callback: (data: ProductOutput) => void) {
    this.session.retrieve(
      { type: 'Product', productId: this.productId },
      callback
    );
  }
}

export type { ProductData };

export function useProductManager(productId: number): ProductManager {
  return new ProductManager(productId);
}
