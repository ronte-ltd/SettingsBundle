<?php

namespace RonteLtd\SettingsBundle\Model;

interface SettingManagerInterface
{
  /**
   * @return string
   */
  public function getClass(): string;

  /**
   * Create new instance of SettingInterface.
   *
   * @return SettingInterface
   */
  public function createSetting(): SettingInterface;

  /**
   * Get setting by name.
   *
   * @param string $name
   * @return SettingInterface
   */
  public function getSetting(string $name): SettingInterface;

  /**
   * Delete setting.
   *
   * @param SettingInterface $setting
   */
  public function deleteSetting(SettingInterface $setting);

  /**
   * Update setting.
   *
   * @param SettingInterface $setting
   */
  public function updateSetting(SettingInterface $setting);

  /**
   * Set value.
   *
   * @param string $name
   * @param mixed $value
   * @param string|null $type if no type specified the result of gettype of $value MUST be set
   *
   * @see http://php.net/manual/en/function.gettype.php
   */
  public function setValue(string $name, $value, string $type = null);

  /**
   * Get value by name.
   *
   * @param string $name
   * @param mixed|null $default default value
   * @return mixed
   */
  public function getValue(string $name, $default = null);

  /**
   * Get value's type.
   *
   * @return mixed returns null if no settings with such name found, string otherwise
   */
  public function getType(string $name);
}
