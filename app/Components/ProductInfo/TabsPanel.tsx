import { useState } from 'react';

type TabsPanelProps = {
  description: string;
  features?: string[];
  featuresCaption?: string;
};

export default function TabsPanel({
  description,
  features = [],
  featuresCaption = 'Caractéristiques',
}: TabsPanelProps) {
  const [activeTab, setActiveTab] = useState('home');

  return (
    <>
      <ul className="nav nav-tabs" id="myTab" role="tablist">
        <li className="nav-item" role="presentation">
          <button
            className={`nav-link${activeTab === 'home' ? ' active' : ''}`}
            id="home-tab"
            type="button"
            role="tab"
            aria-controls="home"
            aria-selected={activeTab === 'home'}
            onClick={() => setActiveTab('home')}
          >
            Description
          </button>
        </li>
        <li className="nav-item" role="presentation">
          <button
            className={`nav-link${activeTab === 'profile' ? ' active' : ''}`}
            id="profile-tab"
            type="button"
            role="tab"
            aria-controls="profile"
            aria-selected={activeTab === 'profile'}
            onClick={() => setActiveTab('profile')}
          >
            Livraison
          </button>
        </li>
        <li className="nav-item" role="presentation">
          <button
            className={`nav-link${activeTab === 'contact' ? ' active' : ''}`}
            id="contact-tab"
            type="button"
            role="tab"
            aria-controls="contact"
            aria-selected={activeTab === 'contact'}
            onClick={() => setActiveTab('contact')}
          >
            Garanties
          </button>
        </li>
      </ul>
      <div className="tab-content" id="myTabContent">
        <div
          className={`tab-pane fade${activeTab === 'home' ? ' show active' : ''}`}
          id="home"
          role="tabpanel"
          aria-labelledby="home-tab"
        >
          <p className="lead"></p>
          <p>{description}</p>
          {features.length > 0 && (
            <>
              <label htmlFor="features">{featuresCaption} :</label>
              <ul id="features">
                {features.map((item, idx) => (
                  <li key={idx}>{item}</li>
                ))}
              </ul>
            </>
          )}
        </div>
        <div
          className={`tab-pane fade${activeTab === 'profile' ? ' show active' : ''}`}
          id="profile"
          role="tabpanel"
          aria-labelledby="profile-tab"
        >
          ...
        </div>
        <div
          className={`tab-pane fade${activeTab === 'contact' ? ' show active' : ''}`}
          id="contact"
          role="tabpanel"
          aria-labelledby="contact-tab"
        >
          ...
        </div>
      </div>
    </>
  );
}