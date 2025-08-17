import {Identifier} from './Traits/Identifier';
import {Classifier} from './Traits/Classifier';
import {Dater} from "./Traits/Dater";

export interface Campaign extends Identifier, Classifier, Dater {
    name?: string | null;
    startsAt?: string | null;
    endsAt?: string | null;
    discount?: number | null;
}
