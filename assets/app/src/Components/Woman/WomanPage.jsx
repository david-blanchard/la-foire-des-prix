import React from "react";
import Breadcrumb from "../ProductInfo/Breadcrumb.jsx";
import ProductInfo from "../ProductInfo/ProductInfo.jsx";
import AppLayout from "../Layouts/AppLayout.jsx";

export default function WomanPage() {
  return (
    <AppLayout>
      <Breadcrumb />
      <ProductInfo />
    </AppLayout>
  );
}
