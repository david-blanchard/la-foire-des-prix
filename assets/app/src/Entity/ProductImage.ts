import {Identifier} from './Traits/Identifier';
import {Image} from './Image';
import {Product} from './Product';

export interface ProductImage extends Identifier {
    image: Image;
    product: Product;
    createdAt?: string | null;
    updatedAt?: string | null;
}
