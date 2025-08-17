import TopPanel from './TopPanel';
import TabsPanel from './TabsPanel';
import Quantity from './Quantity';
import ImagesPanel from './ImagesPanel';

export default function ProductInfo() {
  return (
    <div className="container marketing">
      <div className="row featurette">
        <div className="col-md-7 order-md-2">
          <TopPanel
            key={1}
            id={1}
            name={"Veste en jean"}
            price={120} brand={"Les Prix Bas"}
            discount={100}
              />
          <TabsPanel description={"Il faut que vous soyez un vrai vendeur pour pouvoir ajouter des images au produit."} />
          <Quantity />
        </div>
        <div className="col-md-5 order-md-1">
          <ImagesPanel isAdmin={false} id={1} />
        </div>
      </div>
    </div>
  );
}