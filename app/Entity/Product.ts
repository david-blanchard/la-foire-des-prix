import type {Identifier} from "./Traits/Identifier";
import type {Classifier} from "./Traits/Classifier";
import type {Brand} from "./Brand";
import type {Dater} from "./Traits/Dater";
import type {Category} from "./Category";

export interface Product extends Identifier, Classifier, Dater, Category {
    name?: string | null;
    description?: string | null;
    moreInfo?: string | null;
    price: number;
    brand?: Brand | null;
}
