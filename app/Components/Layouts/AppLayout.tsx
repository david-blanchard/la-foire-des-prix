import AppHeader from '../Header/AppHeader';
import AppFooter from '../Footer/AppFooter';

type AppLayoutProps = {
  title?: string;
  stylesheets?: React.ReactNode;
  headJavascripts?: React.ReactNode;
  javascripts?: React.ReactNode;
  csrfToken?: string;
  children: React.ReactNode;
};

export default function AppLayout({
  title,
  stylesheets,
  headJavascripts,
  javascripts,
  csrfToken,
  children,
}: AppLayoutProps) {
  return (
    <html lang="en" className="h-100">
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        {csrfToken && <meta name="csrf-token" content={csrfToken} />}
        <meta name="description" content="" />
        <meta charSet="UTF-8" />
        <title>{title}</title>
        {/* Liens CSS */}
        {stylesheets}
        {/* JS dans le head */}
        {headJavascripts}
      </head>
      <body className="d-flex flex-column h-100">
        <AppHeader />
        {children}
        <AppFooter />
        {/* Scripts JS */}
        {javascripts}
      </body>
    </html>
  );
}