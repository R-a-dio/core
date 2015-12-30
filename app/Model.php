<?php

namespace App;

use App\Traits\AliasedFields;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use AliasedFields;

    /**
     * Add a list of alias => original pairs.
     *
     * @var array
     */
    protected $aliases = [];
}
