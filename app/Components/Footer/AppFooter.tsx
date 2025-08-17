const home = '/';
const logo = '/build/images/logos/lesprixbas_smaller.png';

export default function AppFooter() {
  return (
    <footer className="py-5 border-top mt-auto bg-light">
      <div className="container bigfooter">
        <div className="container">
          <div className="row">
            <div className="col-12 col-md">
              <a href={home}>
                <img className="mb-2" src={logo} alt="Les Prix Bas" />
              </a>
              <small className="d-block mb-3 text-muted">&copy; 2021</small>
            </div>
            <div className="col-6 col-md">
              <h5>Features</h5>
              <ul className="list-unstyled text-small">
                <li>
                  <a className="text-muted" href={home}>
                    Cool stuff
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Random feature
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Team feature
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Stuff for developers
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Another one
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Last time
                  </a>
                </li>
              </ul>
            </div>
            <div className="col-6 col-md">
              <h5>Resources</h5>
              <ul className="list-unstyled text-small">
                <li>
                  <a className="text-muted" href={home}>
                    Resource
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Resource name
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Another resource
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Final resource
                  </a>
                </li>
              </ul>
            </div>
            <div className="col-6 col-md">
              <h5>About</h5>
              <ul className="list-unstyled text-small">
                <li>
                  <a className="text-muted" href={home}>
                    Team
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Locations
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Privacy
                  </a>
                </li>
                <li>
                  <a className="text-muted" href={home}>
                    Terms
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  );
}