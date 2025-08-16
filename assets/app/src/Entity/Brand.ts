import {Identifier} from './Traits/Identifier';
import {Classifier} from './Traits/Classifier';
import {Dater} from './Traits/Dater';

export interface Brand extends Identifier, Classifier, Dater {
    name?: string | null;
}
