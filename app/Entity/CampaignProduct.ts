import {Identifier} from './Traits/Identifier';
import {Campaign} from './Campaign';
import {Product} from './Product';

export interface CampaignProduct extends Identifier {
    campaign?: Campaign | null;
    product?: Product | null;
}
