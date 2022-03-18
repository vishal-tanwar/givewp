import {useEffect, useRef, useState} from 'react';
import type {ChangeEventHandler} from 'react';
import {__} from '@wordpress/i18n';

import {donationFormsColumns} from './DonationFormsColumns';
import styles from './AdminDonationFormsPage.module.scss';
import {ListTable} from '@givewp/components';
import {GiveIcon} from "@givewp/components";
import ListTableApi from '../api';
import {debounce} from 'lodash';

declare global {
    interface Window {
        GiveDonationForms: {apiNonce: string; apiRoot: string};
    }
}

const donationFormsApi = new ListTableApi(window.GiveDonationForms);

function getDonationStatusText(donationStatus: DonationStatus): string {
    switch (donationStatus) {
        case DonationStatus.Any:
            return __('All', 'give');
        case DonationStatus.Publish:
            return __('Published', 'give');
        case DonationStatus.Pending:
            return __('Pending', 'give');
        case DonationStatus.Draft:
            return __('Draft', 'give');
        case DonationStatus.Trash:
            return __('Trash', 'give');
    }
}

enum DonationStatus {
    Any = 'any',
    Publish = 'publish',
    Pending = 'pending',
    Draft = 'draft',
    Trash = 'trash',
}

const singleName = __('donation form', 'give');
const pluralName = __('donation forms', 'give');
const title = __('Donation Forms', 'give');

const donationFormFilters = [
    {
        name: 'search',
        type: 'search',
        text: __('Search by name or ID', 'give'),
        ariaLabel: __('Search donation forms', 'give')
    },
    {
        name: 'status',
        type: 'select',
        text: __('status', 'give'),
        values: DonationStatus,
        options: getDonationStatusText
    }
]

export default function AdminDonationFormsPage() {
    const [filters, setFilters] = useState({status: DonationStatus.Any});
    const [debouncedFilters, setDebouncedFilters] = useState({search: ''});

    const setFiltersLater = useRef(
        debounce((filterValue) => setDebouncedFilters(filterValue), 500)
    ).current;

    useEffect(() => {
        return () => {
            setFiltersLater.cancel();
        }
    }, []);

    const handleFilterChange: ChangeEventHandler<HTMLSelectElement> = (event) => {
        setFilters(prevState => ({...prevState, [event.target.name]: event.target.value}));
    }

    const handleSearchChange: ChangeEventHandler<HTMLInputElement> = (event) => {
        setFiltersLater(event.target.value);
    }

    return (
        <article>
            <div className={styles.pageHeader}>
                <GiveIcon size={'1.875rem'}/>
                <h1 className={styles.pageTitle}>{__('Donation Forms', 'give')}</h1>
                <a href="post-new.php?post_type=give_forms" className={styles.addFormButton}>
                    {__('Add Form', 'give')}
                </a>
            </div>
            <div className={styles.searchContainer}>
                {donationFormFilters.map((filter) => (
                    <RenderFilters filter={filter} onChange={handleFilterChange}/>
                ))}
            </div>
            <div className={styles.pageContent}>
                <ListTable
                    filters={{...filters, ...debouncedFilters}}
                    columns={donationFormsColumns}
                    singleName={singleName}
                    pluralName={pluralName}
                    title={title}
                    api={donationFormsApi}
                />
            </div>
        </article>
    );
}

const RenderFilters = ({ filter, onChange }) => {
        switch(filter.type){
            case 'select':
                return (
                    <select
                        key={filter.name}
                        name={filter.name}
                        className={styles.statusFilter}
                        aria-label={__('Filter donation forms by status', 'give')}
                        onChange={onChange}
                    >
                        {Object.values(filter.values).map((value) => (
                            <option key={value} value={value}>
                                {filter.options instanceof Function ?
                                    filter.options(value) :
                                    filter.options[value]
                                }
                            </option>
                        ))}
                    </select>
                );
            case 'search':
                return (
                    <input
                        type="search"
                        aria-label={filter?.ariaLabel}
                        placeholder={filter?.text}
                        onChange={onChange}
                        className={styles.searchInput}
                    />
                );
            default:
                break;
        }
}
