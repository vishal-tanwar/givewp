import {StrictMode, SyntheticEvent, useEffect, useState} from 'react';
import ReactDOM from 'react-dom';
import {__} from '@wordpress/i18n';
import cx from 'classnames';

import styles from './admin-donation-forms.module.scss';
import mockDonationForms from './mock-donation-forms.json';
import Pagination from './components/Pagination.js';

declare global {
    interface Window {
        GiveDonationForms: {apiNonce: string; apiRoot: string};
    }
}

type DonationForm = {
    id: number;
    name: string;
    amount: number | [number, number];
    goal: string | number;
    donations: number;
    datetime: string;
    shortcode: string;
};

async function fetchForms(args: {} = {}) {
    let url = window.GiveDonationForms.apiRoot + '?' + new URLSearchParams(args).toString();
    let response = await fetch(url, {
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': window.GiveDonationForms.apiNonce,
        },
    });
    if (response.ok) {
        const result = await response.json();
        console.log(result);
        return result;
    } else {
        return false;
    }
}

function editDonationFormURL(id: number): URL {
    const url = new URL('post.php', location.href);
    url.searchParams.set('post', id.toString());
    url.searchParams.set('action', 'edit');
    return url;
}

function AdminDonationForms() {
    const [donationForms, setDonationForms] = useState(mockDonationForms);
    const [count, setCount] = useState(2);
    const [page, setPage] = useState(1);
    const perPage = 10;

    useEffect(() => {
        (async () => {
            const donationsResponse = await fetchForms({page: page, perPage: perPage});
            if (donationsResponse) {
                setDonationForms([...donationsResponse.forms]);
                setCount(donationsResponse.total);
            } else {
                setDonationForms([...mockDonationForms]);
            }
        })();
    }, [page]);

    function handleSubmit(event: SyntheticEvent<HTMLFormElement, SubmitEvent> & {target: HTMLFormElement}) {
        event.preventDefault();
        setPage(parseInt(event.target.currentPageSelector.value));
    }

    function deleteForm() {
        // TODO
    }

    return (
        <article>
            <div className={styles.pageHeader}>
                <h1 className={styles.pageTitle}>{__('Donation Forms', 'give')}</h1>
                <a href="post-new.php?post_type=give_forms" className={styles.button}>
                    Add Form
                </a>
            </div>
            <div className={styles.pageContent}>
                <form>
                    <button>Change Page</button>
                    <span className={styles.totalItems}>{count.toString() + ' forms'}</span>
                    <Pagination
                        currentPage={page}
                        totalPages={Math.ceil(count / perPage)}
                        disabled={false}
                        setPage={setPage}
                    />
                </form>
                <div role="group" aria-labelledby="giveDonationFormsTableCaption" className={styles.tableGroup}>
                    <table className={styles.table}>
                        <caption id="giveDonationFormsTableCaption" className={styles.tableCaption}>
                            {__('Donation Forms', 'give')}
                        </caption>
                        <thead>
                            <tr>
                                <th scope="col" aria-sort="none" className={styles.tableColumnHeader}>
                                    {__('Name', 'give')}
                                </th>
                                <th
                                    scope="col"
                                    aria-sort="none"
                                    className={styles.tableColumnHeader}
                                    style={{textAlign: 'end'}}
                                >
                                    {__('Amount', 'give')}
                                </th>
                                <th scope="col" aria-sort="none" className={styles.tableColumnHeader}>
                                    {__('Goal', 'give')}
                                </th>
                                <th scope="col" aria-sort="none" className={styles.tableColumnHeader}>
                                    {__('Donations', 'give')}
                                </th>
                                <th scope="col" aria-sort="none" className={styles.tableColumnHeader}>
                                    {__('Shortcode', 'give')}
                                </th>
                                <th scope="col" aria-sort="ascending" className={styles.tableColumnHeader}>
                                    {__('Date', 'give')}
                                </th>
                            </tr>
                        </thead>
                        <tbody className={styles.tableContent}>
                            {donationForms.map((form) => (
                                <tr key={form.id} className={styles.tableRow}>
                                    <th className={cx(styles.tableCell, styles.tableRowHeader)} scope="row">
                                        <a href={editDonationFormURL(form.id).href}>{form.name}</a>
                                        <div role="group" aria-label={__('Actions', 'give')}>
                                            <a href={editDonationFormURL(form.id).href} className={styles.action}>
                                                Edit <span className="give-visually-hidden">{form.name}</span>
                                            </a>
                                            <button type="button" onClick={deleteForm} className={styles.action}>
                                                Delete <span className="give-visually-hidden">{form.name}</span>
                                            </button>
                                        </div>
                                    </th>
                                    <td className={styles.tableCell} style={{textAlign: 'end'}}>
                                        {form.amount}
                                    </td>
                                    <td className={styles.tableCell}>{form.goal ? form.goal : 'No Goal Set'}</td>
                                    <td className={styles.tableCell}>{form.donations}</td>
                                    <td className={styles.tableCell}>{form.shortcode}</td>
                                    <td className={styles.tableCell}>{form.datetime}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </article>
    );
}

ReactDOM.render(
    <StrictMode>
        <AdminDonationForms />
    </StrictMode>,
    document.getElementById('give-admin-donation-forms-root')
);
