import type {Identifier} from './Traits/Identifier.ts';
import type {Image} from './Image.ts';
import type {Product} from './Product.ts';

export interface ProductImage extends Identifier {
    image: Image;
    product: Product;
    createdAt?: string | null;
    updatedAt?: string | null;
}
