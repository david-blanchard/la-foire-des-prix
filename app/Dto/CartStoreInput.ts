import type {CartStoreInputContent} from './CartStoreInputContent.ts';

export interface CartStoreInput {
  type?: string | null;
  content?: CartStoreInputContent[];
}
