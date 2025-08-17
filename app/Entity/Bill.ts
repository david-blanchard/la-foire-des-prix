import type {User} from './User.ts';
import type {BillLineProduct} from './BillLineProduct.ts';
import type {Identifier} from './Traits/Identifier.ts';
import type {Dater} from "./Traits/Dater";

export interface Bill extends Identifier, Dater {
    vat?: number | null;
    client?: User | null;
    billLines?: BillLineProduct[];
}
