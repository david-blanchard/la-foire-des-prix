import type {Identifier} from './Traits/Identifier.ts';
import type {Classifier} from './Traits/Classifier.ts';
import type {Bill} from './Bill.ts';
import type {Product} from './Product.ts';

export interface BillLineProduct extends Identifier, Classifier {
    name?: string | null;
    quantity: number;
    bill?: Bill | null;
    product?: Product | null;
}
