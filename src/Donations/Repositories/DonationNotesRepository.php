<?php

namespace Give\Donations\Repositories;

use Exception;
use Give\Donations\Models\DonationNote;
use Give\Framework\Database\DB;
use Give\Framework\Exceptions\Primitives\InvalidArgumentException;
use Give\Framework\Models\ModelQueryBuilder;
use Give\Framework\Support\Facades\DateTime\Temporal;
use Give\Helpers\Hooks;
use Give\Log\Log;

/**
 * @unreleased
 */
class DonationNotesRepository
{

    /**
     * @unreleased
     *
     * @var string[]
     */
    private $requiredDonationProperties = [
        'donationId',
        'content',
    ];

    /**
     * @unreleased
     *
     * @param  int  $noteId
     *
     * @return DonationNote|null
     */
    public function getById($noteId)
    {
        return $this->prepareQuery()
            ->where('comment_ID', $noteId)
            ->get();
    }

    /**
     * @unreleased
     *
     * @param  DonationNote  $donationNote
     *
     * @return DonationNote
     * @throws Exception|InvalidArgumentException
     */
    public function insert(DonationNote $donationNote)
    {
        $this->validateDonationNote($donationNote);

        Hooks::doAction('give_donation_note_creating', $donationNote);

        $date = $donationNote->createdAt ? Temporal::getFormattedDateTime(
            $donationNote->createdAt
        ) : Temporal::getCurrentFormattedDateForDatabase();


        DB::query('START TRANSACTION');

        try {
            DB::table('give_comments')
                ->insert([
                    'comment_content' => $donationNote->content,
                    'comment_date' => $date,
                    'comment_date_gmt' => get_gmt_from_date($date),
                    'comment_parent' => $donationNote->donationId,
                    'comment_type' => 'donation',
                ]);
        } catch (Exception $exception) {
            DB::query('ROLLBACK');

            Log::error('Failed creating a donation note', compact('donationNote'));

            throw new $exception('Failed creating a donation note');
        }

        DB::query('COMMIT');

        $donationNoteId = DB::last_insert_id();

        $donationNote = $this->getById($donationNoteId);

        Hooks::doAction('give_donation_note_created', $donationNote);

        return $donationNote;
    }

    /**
     * @unreleased
     *
     * @param  DonationNote  $donationNote
     *
     * @return DonationNote
     * @throws Exception|InvalidArgumentException
     */
    public function update(DonationNote $donationNote)
    {
        $this->validateDonationNote($donationNote);

        Hooks::doAction('give_donation_note_updating', $donationNote);

        DB::query('START TRANSACTION');

        try {
            DB::table('give_comments')
                ->where('comment_ID', $donationNote->id)
                ->update([
                    'comment_content' => $donationNote->content,
                    'comment_parent' => $donationNote->donationId,
                    'comment_type' => 'donation',
                ]);
        } catch (Exception $exception) {
            DB::query('ROLLBACK');

            Log::error('Failed updating a donation note', compact('donationNote'));

            throw new $exception('Failed updating a donation note');
        }

        DB::query('COMMIT');

        Hooks::doAction('give_donation_note_updated', $donationNote );

        return $donationNote;
    }

    /**
     * @unreleased
     *
     * @param  DonationNote  $donationNote
     * @return bool
     * @throws Exception
     */
    public function delete(DonationNote $donationNote)
    {
        DB::query('START TRANSACTION');

        Hooks::doAction('give_donation_note_deleting', $donationNote);

        try {
            DB::table('give_comments')
                ->where('comment_ID', $donationNote->id)
                ->delete();
        } catch (Exception $exception) {
            DB::query('ROLLBACK');

            Log::error('Failed deleting a donation note', compact('donationNote'));

            throw new $exception('Failed deleting a donation note');
        }

        DB::query('COMMIT');

        Hooks::doAction('give_donation_note_deleted', $donationNote);

        return true;
    }

    /**
     * @unreleased
     *
     * @param  int  $donationId
     *
     * @return object[]
     */
    public function getByDonationId($donationId)
    {
        return $this->prepareQuery()
            ->where('comment_parent', $donationId)
            ->getAll();
    }

    /**
     * @unreleased
     *
     * @param  DonationNote  $donationNote
     * @return void
     */
    private function validateDonationNote(DonationNote $donationNote)
    {
        foreach ($this->requiredDonationProperties as $key) {
            if (!isset($donationNote->$key)) {
                throw new InvalidArgumentException("'$key' is required.");
            }
        }

        if (!$donationNote->donation){
            throw new InvalidArgumentException("Invalid donationId, Donation does not exist");
        }
    }

    /**
     * @return ModelQueryBuilder
     */
    public function prepareQuery()
    {
        $builder = new ModelQueryBuilder();

        return $builder->from('give_comments')
            ->setModel(DonationNote::class)
            ->select(
                ['comment_ID', 'id'],
                ['comment_parent', 'donationId'],
                ['comment_content', 'content'],
                ['comment_date', 'createdAt']
            )
            ->where('comment_type', 'donation');
    }
}
