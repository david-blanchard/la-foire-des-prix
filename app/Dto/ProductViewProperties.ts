import type { Image } from '../Entity/Image.ts';

export interface ProductViewProperties {
  id: number;
  name: string;
  description: string;
  moreInfo: string;
  price: number;
  brand: string;
  discountRate: number;
  discount: number;
  featuresCaption: string;
  features: string[];
  images: Image[];
}
