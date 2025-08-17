import AppLayout from '../Layouts/AppLayout.tsx';

export default function ServerErrorPage() {
  return (
    <AppLayout title="Erreur serveur">
      <div className="container">
        <div className="row my-5 justify-content-center">
          <h1 className="text-center">
            Oops!<br />Nous sommes fermés pour inventaire... ou presque.
          </h1>
        </div>
        <div className="row justify-content-center">
          <img
            src="/build/images/lesprixbas_404.webp"
            width={500}
            height={500}
            alt="Erreur serveur"
          />
        </div>
      </div>
    </AppLayout>
  );
}