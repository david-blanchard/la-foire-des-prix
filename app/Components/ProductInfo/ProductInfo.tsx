import TopPanel from './TopPanel';
import TabsPanel from './TabsPanel';
import Quantity from './Quantity';
import ImagesPanel from './ImagesPanel';
import { useEffect, useState } from 'react';
import { CartData, useCartManager } from '../../Service/CartManager';
import { useProductManager } from '../../Service/ProductManager';
import { ProductViewProperties } from '../../Dto/ProductViewProperties';

export default function ProductInfo() {
  const [product, setProduct] = useState({
    id: 1,
    name: 'Produit 1',
    description: 'Description du produit 1',
    moreInfo: "Plus d'informations sur le produit 1",
    price: 120,
    brand: 'Les Prix Bas',
    discountRate: 20,
    discount: 100,
    featuresCaption: 'Caractéristiques du produit 1',
    features: ['Caractéristique 1', 'Caractéristique 2'],
    images: [
      {
        id: 1,
        url: 'https://via.placeholder.com/150',
        alt: 'Image du produit 1',
      },
    ],
  } as ProductViewProperties);

  const [cartFields, setCartFields] = useState({
    quantity: 1,
    total: 0,
  } as CartData);

  const [quantity, setQuantity] = useState<number>(cartFields.quantity);
  const [mainImage, setMainImage] = useState<string>(
    product.images[0]?.url || ''
  );

  const productManager = useProductManager(1);

  useEffect(() => {
    productManager.retrieve((repsonse) => {
      setProduct(repsonse.data.product);
      setCartFields(repsonse.data.cartFields);
      setMainImage(repsonse.data.product.images[0]?.url || '');
      setQuantity(repsonse.data.cartFields.quantity);
    });
  }, []);

  const cartManager = useCartManager();

  const handleQuantity = (inc: number) => {
    setQuantity((q) => Math.max(1, q + inc));
  };

  const handleAddToCart = () => {
    cartManager.store(product.id, quantity, (data) => {});
  };
  return (
    <div className="container marketing">
      <div className="row featurette">
        <div className="col-md-7 order-md-2">
          <TopPanel
            key={product.id}
            id={product.id}
            name={product.name}
            price={product.price}
            brand={product.brand}
            discount={product.discount}
            discountRate={product.discountRate}
          />
          <TabsPanel
            description={product.description}
            features={product.features}
            featuresCaption={product.featuresCaption}
          />
          <Quantity />
        </div>
        <div className="col-md-5 order-md-1">
          <ImagesPanel isAdmin={false} id={1} />
        </div>
      </div>
    </div>
  );
}
