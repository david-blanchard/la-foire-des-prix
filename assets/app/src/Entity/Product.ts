import {Identifier} from "./Traits/Identifier";
import {Classifier} from "./Traits/Classifier";
import {Brand} from "./Brand";
import {Dater} from "./Traits/Dater";
import {Category} from "./Category";

export interface Product extends Identifier, Classifier, Dater, Category {
    name?: string | null;
    description?: string | null;
    moreInfo?: string | null;
    price: number;
    brand?: Brand | null;
}
