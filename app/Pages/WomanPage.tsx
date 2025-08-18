import Breadcrumb from '../Components/ProductInfo/Breadcrumb';
import ProductInfo from '../Components/ProductInfo/ProductInfo';
import AppLayout from '../Components/Layouts/AppLayout';

export default function WomanPage() {
  return (
    <AppLayout>
      <Breadcrumb name={'Mode femme'} />
      <ProductInfo />
    </AppLayout>
  );
}
