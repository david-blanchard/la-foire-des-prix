import {User} from './User';
import {BillLineProduct} from './BillLineProduct';
import {Identifier} from './Traits/Identifier';
import {Dater} from "./Traits/Dater";

export interface Bill extends Identifier, Dater {
    vat?: number | null;
    client?: User | null;
    billLines?: BillLineProduct[];
}
