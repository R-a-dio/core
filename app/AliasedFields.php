<?php

namespace App;

trait AliasedFields
{
  public function getAttribute($key)
  {
    if (array_key_exists($key, $this->aliases)) {
      $key = $this->aliases[$key];
    }

    return parent::getAttribute($key);
  }

  public function setAttribute($key, $value)
  {
    if (array_key_exists($key, $this->aliases)) {
      $key = $this->aliases[$key];
    }

    return parent::setAttribute($key, $value);
  }
}