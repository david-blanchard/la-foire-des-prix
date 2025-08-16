import React, { useState } from "react";

export default function Quantity() {
  const [quantity, setQuantity] = useState(1);

  const handleLess = () => {
    if (quantity > 1) setQuantity(quantity - 1);
  };

  const handleMore = () => {
    setQuantity(quantity + 1);
  };

  return (
    <div className="row justify-content-between mx-1 my-2">
      <div>
        <ul className="pagination">
          <li className="page-item disabled">
            <span className="page-link" tabIndex={-1} aria-disabled="true">
              Quantité
            </span>
          </li>
          <li className={`page-item${quantity === 1 ? " disabled" : ""}`}>
            <button
              id="less"
              name="quantity-handler"
              className="page-link"
              onClick={handleLess}
              disabled={quantity === 1}
              type="button"
            >
              -
            </button>
          </li>
          <li className="page-item disabled">
            <span id="quantity" name="count" className="page-link">
              {quantity}
            </span>
          </li>
          <li className="page-item">
            <button
              id="more"
              name="quantity-handler"
              className="page-link"
              onClick={handleMore}
              type="button"
            >
              +
            </button>
          </li>
        </ul>
      </div>
      <div>
        <button id="add-to-cart" type="button" className="btn btn-outline-primary">
          Ajouter au panier
        </button>
      </div>
    </div>
  );
}
