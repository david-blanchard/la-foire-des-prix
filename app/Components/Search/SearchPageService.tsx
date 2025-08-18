import React, { useState } from "react";

const Search: React.FC = () => {
  const [value, setValue] = useState<string>("");

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (value.trim()) {
      window.location.href = "/recherche/" + value;
    }
  };

  return (
    <form id="form0" onSubmit={handleSubmit}>
      <input
        id="search"
        name="product"
        value={value}
        onChange={e => setValue(e.target.value)}
        type="text"
      />
      <button id="submit-search-cta" type="submit">
        Rechercher
      </button>
    </form>
  );
};

export default Search;
