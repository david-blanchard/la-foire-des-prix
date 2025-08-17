import Breadcrumb from '../ProductInfo/Breadcrumb.tsx';
import ProductInfo from '../ProductInfo/ProductInfo.tsx';
import AppLayout from '../Layouts/AppLayout.tsx';

export default function SearchPage() {
  return (
    <AppLayout>
      <Breadcrumb name={'Recherche'} />
      <ProductInfo />
    </AppLayout>
  );
}