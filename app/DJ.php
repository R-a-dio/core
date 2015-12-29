<?php

namespace App;

class DJ extends Model
{
    /**
     * Because capitalizing things breaks shit
     *
     * @var string
     */
    protected $table = 'djs';

    /**
     * Aliases fields in the database
     *
     * @var array
     */
    protected $aliases = [
      'name' => 'djname',
      'image' => 'djimage',
    ];

    /**
     * @var array
     */
    protected $casts = [
      'visible' => 'boolean',
    ];
}
