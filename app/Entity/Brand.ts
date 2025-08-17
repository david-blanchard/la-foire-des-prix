import type {Identifier} from './Traits/Identifier.ts';
import type {Classifier} from './Traits/Classifier.ts';
import type {Dater} from './Traits/Dater.ts';

export interface Brand extends Identifier, Classifier, Dater {
    name?: string | null;
}
