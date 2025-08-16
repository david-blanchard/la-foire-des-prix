import React from "react";
import AppHeader from "../Header/AppHeader.jsx";
import AppFooter from "../Footer/AppFooter.jsx";

export default function AppLayout({
  title,
  stylesheets,
  headJavascripts,
  javascripts,
  csrfToken,
  children,
}) {
  return (
    <html lang="en" className="h-100">
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content={csrfToken} />
        <meta name="description" content="" />
        <meta charSet="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
