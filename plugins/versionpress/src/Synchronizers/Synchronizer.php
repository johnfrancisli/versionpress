<?php

namespace VersionPress\Synchronizers;
/**
 * Synchronizers synchronize entities from {@link EntityStorage storages} back to the database.
 *
 * Most storages have their complementary synchronizers so the typical relationship is 1:1 but in some
 * cases, there may be more synchronizers for a single storage. For example, both VersionPress\Synchronizers\PostsSynchronizer
 * and VersionPress\Synchronizers\TermRelationshipsSynchronizer exist for VersionPress\Storages\PostStorage.
 *
 * Synchronizers do work that is kind of opposite to the ones of storages but with one major
 * difference: while storages usually add or delete entities one by one or by small amounts,
 * synchronizers operate over all entities and completely overwrite the whole db table
 * (with the exception of untracked or ignored rows, see below). Synchronizers also sometimes
 * execute additional SQL queries to get the database to a fully working state - for example,
 * the VersionPress\Synchronizers\PostsSynchronizer counts comments and updates the `comment_count` field.
 *
 * Synchronizers are run by the {@link VersionPress\Synchronizers\SynchronizationProcess}.
 */
interface Synchronizer {

    const SYNCHRONIZE_EVERYTHING = 'everything';

    /**
     * Synchronizes entities from storage to the database. It generally only works with tracked
     * entities, i.e. the ignored (untracked) rows in the database are left untouched. The rows
     * corresponding to tracked entities are usually in sync with the storage after this method
     * is done. It may happen that the synchronizer cannot synchronize everything in the first
     * pass. Because of this, the synchronize method takes a task for sychronization (usually
     * "everything" for the first pass) and returns another task that isn't done yet. It's up
     * to the SynchronizationProcess to call the synchronize method again with this task when
     * the first pass is done.
     *
     * @param string $task
     * @return string|null
     */
    function synchronize($task);
}
