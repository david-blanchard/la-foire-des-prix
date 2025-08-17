import {Identifier} from './Traits/Identifier';
import {Classifier} from './Traits/Classifier';
import {Bill} from './Bill';
import {Product} from './Product';

export interface BillLineProduct extends Identifier, Classifier {
    name?: string | null;
    quantity: number;
    bill?: Bill | null;
    product?: Product | null;
}
