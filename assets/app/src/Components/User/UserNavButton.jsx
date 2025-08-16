import React from "react";

export default function UserNavButton({ user, isAdmin, onLogout, homeUrl, adminUiUrl, loginUrl, registerUrl }) {
  return (
    <div className="dropdown">
      <button
        type="button"
        className="btn btn-secondary dropdown-toggle my-2 my-sm-0 ml-3"
        id="dropdown01"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
      >
        <i className="fa fa-user-circle-o"></i>
        <i className="fa fa-user-circle"></i>
      </button>
      <div className="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
        {!user ? (
          <>
            <a className="dropdown-item" href={loginUrl}>Connexion</a>
            <a className="dropdown-item" href={registerUrl}>Pas encore inscrit ?</a>
          </>
        ) : null}
        <a
          className="dropdown-item"
          href="#"
          onClick={e => {
            e.preventDefault();
            onLogout();
          }}
        >
          Déconnexion
        </a>
        {!isAdmin ? (
          <>
            <a className="dropdown-item" href={homeUrl}>F.A.Q</a>
            <a className="dropdown-item" href={homeUrl}>Mentions légales</a>
          </>
        ) : (
          <a className="dropdown-item" href={adminUiUrl}>Admin UI</a>
        )}
      </div>
    </div>
  );
}
