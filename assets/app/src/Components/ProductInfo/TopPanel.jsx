import React from "react";

export default function TopPanel({
  id,
  name,
  brand,
  price,
  discount,
  discountRate,
  formatPrice
}) {
  const hasDiscount = discount > 0 && discount < price;
  const priceTag = hasDiscount ? discount : price;
  const basePrice = price;

  return (
    <>
      <div className="row mx-1">
        <div id="product" name="product-data" data-id={id}>
          <h4 className="featurette-heading">{name}</h4>
        </div>
      </div>
      <div className="row justify-content-between mx-1">
        <div>
          <h5 className="featurette-heading">{brand}</h5>
        </div>
        <div>
          {hasDiscount && (
            <h6
              id="stroke-price-tag"
              name="unit-price"
              className="btn-outline-danger disabled"
            >
              <del>
                {formatPrice ? formatPrice(basePrice) : basePrice}{" "}
                <i className="fa fa-euro"></i>
              </del>
            </h6>
          )}
          <h3
            id="price-tag"
            name="unit-price"
            data-discount-rate={discountRate}
            className="btn-outline-success disabled"
          >
            {formatPrice ? formatPrice(priceTag) : priceTag}&nbsp;
            <i className="fa fa-euro"></i>
          </h3>
        </div>
      </div>
    </>
  );
}
