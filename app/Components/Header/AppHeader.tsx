import type { User } from '../../Entity/User.ts';

import SearchNavBar from '../Search/SearchNavBar';
import CartNavButton from '../Cart/CartNavButton';
import UserNavButton from '../User/UserNavButton';

const logoDesktop = '/build/images/logos/lesprixbas_small.png';
const logoMobile = '/build/images/logos/lesprixbas_smaller.png';

type AppHeaderProps = {
  home?: string;
};

const fakeUser: User | null = null; // Remplacer par l'utilisateur réel si besoin

export default function AppHeader({ home = '/' }: AppHeaderProps) {
  // Valeurs fictives pour l’exemple
  const cartQuantity = 0;
  const cartTotal = '0,00 €';
  const isAdmin = false;
  const adminUiUrl = '/admin';
  const loginUrl = '/login';
  const registerUrl = '/register';

  return (
    <header>
      <nav id="navbar0" className="navbar navbar-expand-md fixed-top navbar-dark bg-white shadow-sm">
        <a className="navbar-brand mr-auto mr-lg-0" href={home}>
          <picture>
            <source srcSet={logoMobile} media="(max-width: 1200px)" />
            <source srcSet={logoDesktop} media="(min-width: 1200px)" />
            <img id="logo" src={logoDesktop} alt="Les Prix Bas" />
          </picture>
        </a>

        <div id="subnavbar0" className="navbar-collapse offcanvas-collapse">
          <ul className="navbar-nav navbar-dark mr-auto"></ul>
          <SearchNavBar onSubmit={() => {}} value="" onChange={() => {}} />
          <CartNavButton quantity={cartQuantity} total={cartTotal} />
          <UserNavButton
            user={fakeUser}
            isAdmin={isAdmin}
            onLogout={() => {}}
            homeUrl={home}
            adminUiUrl={adminUiUrl}
            loginUrl={loginUrl}
            registerUrl={registerUrl}
          />
        </div>
      </nav>

      <div id="placeholder" aria-label="placeholder"></div>

      <div id="subnavbar1" className="nav-scroller bg-light shadow-sm">
        <nav className="nav nav-underline">
          <div className="nav-item active">
            <a className="nav-link bg-light align-text-bottom" href={home}>
              Tous nos rayons <span className="sr-only">(current)</span>
            </a>
          </div>
        </nav>
      </div>
    </header>
  );
}