<?php

namespace RonteLtd\SettingsBundle\Model;

trait SettingTrait
{
  private static function getEval(&$variable, string $value)
  {
    eval('$variable = ' . $value . ';');
  }

  protected function stringToValue(string $value)
  {
    self::getEval($ret, $value);
    return $ret;
  }

  protected function valueToString($value): string
  {
    return var_exports($value, true);
  }
}
