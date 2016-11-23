<?php

namespace RonteLtd\SettingsBundle\Propel;

use RonteLtd\SettingsBundle\Model\SettingManager as BaseSettingManager;
use RonteLtd\SettingsBundle\Model\SettingInterface;

class SettingManager extends BaseSettingManager
{
  /** @var string */
  protected $class;

  /** @param string $class a class name */
  public function __construct(string $class)
  {
    $this->class = $class;
  }

  /** {@inheritdoc} */
  public function getClass(): string
  {
    return $this->class;
  }

  /** {@inheritdoc} */
  public function getSetting(string $name): SettingInterface
  {
    $queryClass = $this->class.'Query';
    return $queryClass::create()
      ->filterByName($name)
      ->findOne();
  }

  /** {@inheritdoc} */
  public function deleteSetting(SettingInterface $setting)
  {
    $setting->delete();
  }

  /** {@inheritdoc} */
  public function updateSetting(SettingInterface $setting)
  {
    $setting->save();
  }

  /** {@inheritdoc} */
  public function unsetValue(string $name)
  {
    $queryClass = $this->class.'Query';
    $queryClass::create()
      ->filterByName($name)
      ->delete();
  }
}
