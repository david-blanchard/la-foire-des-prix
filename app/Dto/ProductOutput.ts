import { CartData } from '../Service/CartManager';
import { ProductViewProperties } from './ProductViewProperties';

export interface ProductOutput {
  status: string;
  data: {
    product: ProductViewProperties;
    cartFields: CartData;
  };
}
