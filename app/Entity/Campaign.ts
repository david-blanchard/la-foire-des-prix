import type {Identifier} from './Traits/Identifier.ts';
import type {Classifier} from './Traits/Classifier.ts';
import type {Dater} from "./Traits/Dater";

export interface Campaign extends Identifier, Classifier, Dater {
    name?: string | null;
    startsAt?: string | null;
    endsAt?: string | null;
    discount?: number | null;
}
