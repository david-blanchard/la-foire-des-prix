import Breadcrumb from '../Components/ProductInfo/Breadcrumb';
import ProductInfo from '../Components/ProductInfo/ProductInfo';
import AppLayout from '../Components/Layouts/AppLayout';

export default function SearchPage() {
  return (
    <AppLayout>
      <Breadcrumb name={'Recherche'} />
      <ProductInfo />
    </AppLayout>
  );
}
