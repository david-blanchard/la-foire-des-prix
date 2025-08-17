import AppLayout from '../Layouts/AppLayout.tsx';

export default function NotFoundPage() {
  return (
    <AppLayout title="Page non trouvée">
      <div className="container">
        <div className="row my-5 justify-content-center">
          <h1 className="text-center">
            Oops!<br />Nous n'avons pas ce produit en magasin...
          </h1>
        </div>
        <div className="row justify-content-center">
          <img
            src="/build/images/lesprixbas_404.webp"
            width={500}
            height={500}
            alt="404 page not found"
          />
        </div>
      </div>
    </AppLayout>
  );
}