import React from "react";

export default function Breadcrumb({ name }) {
  return (
    <nav id="breadcrumb0" aria-label="breadcrumb">
      <ol className="breadcrumb">
        <li className="breadcrumb-item"><a href="#">Accueil</a></li>
        <li className="breadcrumb-item"><a href="#">Mode femme</a></li>
        <li className="breadcrumb-item active" aria-current="page">{name}</li>
      </ol>
    </nav>
  );
}
