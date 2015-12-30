<?php

namespace App;

use App\Traits\HasStatus;
use Venturecraft\Revisionable\RevisionableTrait;

class Song extends Model
{
    use RevisionableTrait {
        boot as _unused; // remove the boot method override
    }

    use HasStatus;

    /**
     * Years of this and we still haven't properly named tables, etc.
     *
     * @var string
     */
    protected $table = 'tracks';

    /**
     * Hiding cheese, ho!
     *
     * @var array
     */
    protected $aliases = [
        'title' => 'track',
        'played_at' => 'lastplayed',
        'requested_at' => 'lastrequested',
    ];

    /**
     * Cast values.
     *
     * @var array
     */
    protected $casts = [
        'usable' => 'boolean',
        'needs_reupload' => 'boolean',
    ];

    /**
     * Filters out songs to only include accepted ones.
     *
     * @var string
     */
    protected $withStatus = 'accepted';
}
