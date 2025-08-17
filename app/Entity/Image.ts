import {Identifier} from './Traits/Identifier';
import {Dater} from "./Traits/Dater";

export interface Image extends Identifier, Dater {
    url: string;
    alt: string;
    title?: string | null;
}
