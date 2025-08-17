import React from "react";
import Breadcrumb from "../ProductInfo/Breadcrumb.tsx";
import ProductInfo from "../ProductInfo/ProductInfo.tsx";
import AppLayout from "../Layouts/AppLayout.tsx";

export default function WomanPage() {
  return (
    <AppLayout>
      <Breadcrumb />
      <ProductInfo />
    </AppLayout>
  );
}
