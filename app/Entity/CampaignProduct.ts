import type {Identifier} from './Traits/Identifier.ts';
import type {Campaign} from './Campaign.ts';
import type {Product} from './Product.ts';

export interface CampaignProduct extends Identifier {
    campaign?: Campaign | null;
    product?: Product | null;
}
