type TopPanelProps = {
  id: string | number;
  name: string;
  brand: string;
  price: number;
  discount: number;
  discountRate?: number;
  formatPrice?: (value: number) => string;
};

export default function TopPanel({
  id,
  name,
  brand,
  price,
  discount,
  discountRate,
}: TopPanelProps) {
  const hasDiscount = discount > 0 && discount < price;
  const priceTag = hasDiscount ? discount : price;
  const basePrice = price;

  const formatPrice= (value: number): string => { return value.toFixed(2); }
  return (
    <>
      <div className="row mx-1">
        <div id="product" data-name="product-data" data-id={id}>
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
              data-name="unit-price"
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
            data-name="unit-price"
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