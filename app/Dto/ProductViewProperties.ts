import type {Image} from "../Entity/Image.ts";

export interface ProductViewProperties {
  id?: number | null;
  name?: string | null;
  description?: string | null;
  moreInfo?: string | null;
  price: number;
  brand?: string | null;
  discountRate: number;
  discount: number;
  featuresCaption: string;
  features: string[];
  images: Image[];
}
