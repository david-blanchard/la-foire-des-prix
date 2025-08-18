import React from 'react';
import ProductImage from './ProductImage';

import type { Image } from '../../Entity/Image';

type ImagesPanelProps = {
  images?: Image[];
  isAdmin: boolean;
  id: string | number;
  onAddImages?: React.MouseEventHandler<HTMLAnchorElement>;
};

function ImagesPanel({
  images = [],
  isAdmin,
  id,
  onAddImages,
}: ImagesPanelProps) {
  const hasNoImage = !images[0];
  const fallbackImage: Image = {
    url: '/assets/images/misc/no-image.png',
    alt: "pas d'image disponible",
  };
  const displayImages = hasNoImage ? Array(4).fill(fallbackImage) : images;

  return (
    <div>
      <div id="main-picto">
        <ProductImage image={displayImages[0]} size={500} />
      </div>
      <div>
        {displayImages.map((image, idx) => (
          <button
            key={idx}
            className={`btn${idx === 0 ? ' focus' : ''}`}
            name="btn-picto"
            tabIndex={0}
            data-toggle="button"
            aria-pressed={idx === 0 ? 'true' : 'false'}
            type="button"
          >
            <ProductImage image={image} size={50} />
          </button>
        ))}
      </div>
      {isAdmin && (
        <div className="row bg-cyan justify-content-center my-3 mx-3">
          <a
            href={`/admin/product/images/create/${id}`}
            className="btn btn-outline-danger"
            onClick={onAddImages}
          >
            Ajouter des images au produit
          </a>
        </div>
      )}
    </div>
  );
}

export type { ImagesPanelProps };
export default ImagesPanel;
