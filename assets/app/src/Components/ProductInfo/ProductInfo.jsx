import React from "react";
import TopPanel from "./TopPanel";
import TabsPanel from "./TabsPanel";
import Quantity from "./Quantity";
import ImagesPanel from "./ImagesPanel";

export default function ProductInfo() {
  return (
    <div className="container marketing">
      <div className="row featurette">
        <div className="col-md-7 order-md-2">
          <TopPanel />
          <TabsPanel />
          <Quantity />
        </div>
        <div className="col-md-5 order-md-1">
          <ImagesPanel />
        </div>
      </div>
    </div>
  );
}
