import type { Image } from "../../Entity/Image";

type ProductImageProps = {
  image: Image;
  size: number;
};

export default function ProductImage({ image, size }: ProductImageProps) {
  if (!image) {
    return null; // Gestion d'un cas où l'image est indéfinie
  }

  return (
    <img
      src="/build/images/blank.gif"
      data-src={image.url}
      data-name="picto"
      alt={image.alt}
      className="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
      width={size}
      height={size}
      aria-label={image.alt}
    />
  );
}