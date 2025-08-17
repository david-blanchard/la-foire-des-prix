import type {Identifier} from './Traits/Identifier.ts';
import type {Dater} from "./Traits/Dater";

export interface Image extends Identifier, Dater {
    url: string;
    alt: string;
}
