<?php

namespace App\Traits;

use App\Scopes\StatusScope;
use LogicException;

trait HasStatus
{
    public static function bootHasStatus()
    {
        static::addGlobalScope(new StatusScope());
    }

    public function getStatusForScope()
    {
        if (isset($this->withStatus)) {
            return $this->withStatus;
        }

        throw new LogicException('The withStatus property must be set on ' . get_called_class());
    }
}
