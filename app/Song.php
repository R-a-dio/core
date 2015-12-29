<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
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
}