import {useState} from 'react';
import {render} from 'react-dom';

import {__} from '@wordpress/i18n';

import ADDONS from './mock-addons.json';

import './addon-gallery.css';

const AddonCard = ({name, description, features, actionLink}) => (
	<li className="give-addon-gallery-addon-cta-card">
		<article>
			<h3>{name}</h3>
			<p>{description}</p>
			<ul>
				{features.map(feature => (
					<li key={feature}>{feature}</li>
				))}
			</ul>
			<a className="give-addon-gallery-addon-cta-card__button" href={actionLink}>Learn more</a>
		</article>
	</li>
)

const MustHaveAddons = () => (
	<article className="give-addon-gallery-tab-container">
		<h2>{__('Ready to take your fundraising to the next level?', 'give')}</h2>
		<p>{__('Recurring donations, fee recovery, and more powerful add-ons to power your campaigns from A to Z.', 'give')}</p>
		<ul className="give-addon-gallery-addon-grid">
			{ADDONS.map(addon => <AddonCard key={addon.name} {...addon} />)}
		</ul>
	</article>
)

const PricingPlans = () => (
	<article>
		Pricing Plans
	</article>
);

const AdditionalAddons = () => (
	<article>
		Additional Add-ons
	</article>
);

const Fonts___TEMP = () => <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet" />;

// Not designed for re-used beyond this file.
const Tab = ({index, children, isSelected, onSelect}) => (
	<button
		type="button"
		role="tab"
		aria-selected={isSelected}
		aria-controls={`give-addon-gallery-tab-panel-${index}`}
		tabIndex={isSelected ? 0 : -1}
		onClick={onSelect}
		id={`give-addon-gallary-tab-${index}`}
	>
		{children}
	</button>
);

// Not designed for re-used beyond this file.
const TabPanel = ({children, index, isSelected}) => (
	<div
		role="tabpanel"
		aria-labelledby={`give-addon-gallary-tab-${index}`}
		id={`give-addon-gallery-tab-panel-${index}`}
		tabIndex={isSelected ? 0 : -1}
		hidden={!isSelected}
	>
		{children}
	</div>
);

function AddonGallery() {
	const [currentTab, setCurrentTab] = useState(1);

	return (
		<article className="give-addon-gallery">
			<Fonts___TEMP />
			<div>
				<h1>
					{__('Give Add-ons Gallery', 'give')}
				</h1>
				<div role="tablist" aria-orientation="horizontal">
					<Tab index={1} isSelected={currentTab === 1} onSelect={() => setCurrentTab(1)}>
						{__('Must Have Add-ons', 'give')}
					</Tab>
					<Tab index={2} isSelected={currentTab === 2} onSelect={() => setCurrentTab(2)}>
						{__('View Pricing Plans', 'give')}
					</Tab>
					<Tab index={3} isSelected={currentTab === 3} onSelect={() => setCurrentTab(3)}>
						{__('Additional Add-ons', 'give')}
					</Tab>
				</div>
			</div>
			<TabPanel index={1} isSelected={currentTab === 1}>
				<MustHaveAddons />
			</TabPanel>
			<TabPanel index={2} isSelected={currentTab === 2}>
				<PricingPlans />
			</TabPanel>
			<TabPanel index={3} isSelected={currentTab === 3}>
				<AdditionalAddons />
			</TabPanel>
		</article>
	);
}

render(
	<AddonGallery />,
	document.getElementById('root'),
);
