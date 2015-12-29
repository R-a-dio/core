<?php

namespace App;

trait AliasedFields
{
  /**
   * @param $key
   *
   * @return mixed
   */
  public function getAttribute($key)
  {
    if (array_key_exists($key, $this->aliases)) {
      $key = $this->aliases[$key];
    }

    return parent::getAttribute($key);
  }

  /**
   * @param $key
   * @param $value
   *
   * @return mixed
   */
  public function setAttribute($key, $value)
  {
    if (array_key_exists($key, $this->aliases)) {
      $key = $this->aliases[$key];
    }

    return parent::setAttribute($key, $value);
  }

  /**
   * Show aliased output for arrays.
   *
   * @return array
   */
  public function toArray()
  {
    $array = parent::toArray();
    $replacements = array_flip($this->aliases);
    list($keys, $values) = array_divide($array);

    $keys = array_map(function ($key) use ($replacements) {
      return array_key_exists($key, $replacements) ? $replacements[$key] : $key;
    }, $keys);

    return array_combine($keys, $values);
  }
}