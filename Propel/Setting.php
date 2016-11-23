<?php

namespace RonteLtd\SettingsBundle\Propel;

use RonteLtd\SettingsBundle\Propel\om\Setting as BaseSetting;
use RonteLtd\SettingsBundle\Model\SettingInterface;
use RonteLtd\SettingsBundle\Model\SettingTrait;

class Setting extends BaseSetting implements SettingInterface
{
  use SettingTrait;

  /** {@inheritdoc} */
  public function setValue($value)
  {
    $this->getRawValue($this->valueToString($value));
    return $this;
  }

  /** {@inheritdoc} */
  public function getValue()
  {
    return $this->stringToValue($this->getRawValue());
  }
}
