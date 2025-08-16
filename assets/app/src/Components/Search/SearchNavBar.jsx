import React from "react";

export default function SearchNavBar({ onSubmit, value, onChange }) {
  return (
    <form
      id="form0"
      className="my-2 btn-group"
      action="javascript:void(0)"
      method="GET"
      onSubmit={onSubmit}
    >
      <input
        id="search"
        name="product"
        className="form-control"
        type="text"
        placeholder="Lancez-vous"
        aria-label="Recherche"
        value={value}
        onChange={onChange}
      />
      <button
        type="submit"
        id="submit-search-cta"
        className="btn btn-outline-success my-sm-0"
      >
        <i className="fa fa-search"></i>
      </button>
    </form>
  );
}
