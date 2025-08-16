import React from "react";

export default function ProductImage({ image, size }) {
  return (
    <img
      src={"/build/images/blank.gif"}
      data-src={image.url}
      name="picto"
      alt={image.alt}
      title={image.title}
      className="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto"
      width={size}
      height={size}
      preserveAspectRatio="xMidYMid slice"
      focusable="false"
      aria-label={image.title}
    />
  );
}
