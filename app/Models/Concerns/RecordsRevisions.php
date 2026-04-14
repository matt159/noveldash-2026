<?php

namespace App\Models\Concerns;

use Venturecraft\Revisionable\RevisionableTrait;

trait RecordsRevisions
{
    use RevisionableTrait;

    /**
     * Whether to store revisions on model creation.
     */
    protected bool $revisionCreationsEnabled = true;

    /**
     * Fields that should never be tracked.
     *
     * @var array<int, string>
     */
    protected array $dontKeepRevisionOf = [
        'created_at',
        'updated_at',
    ];
}
