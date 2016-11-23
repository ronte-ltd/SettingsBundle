<?php

namespace RonteLtd\SettingsBundle\CacheModel;

use RonteLtd\SettingsBundle\Model\SettingManager as BaseSettingManager;
use RonteLtd\SettingsBundle\Model\SettingInterface;

class SettingManager extends BaseSettingManager
{
  /** @var Cache */
  protected $cache;

  /** @var int */
  protected $livetime;

  /** @var string */
  protected $prefix;

  /** @var string */
  protected $class;

  public function __construct(Cache $cache, string $class,
                              string $prefix = '', int $livetime = 0)
  {
    $this->cache = $cache;
    $this->class = $class;
    $this->prefix = $prefix;
    $this->livetime = $livetime;
  }

  /** {@inheritdoc} */
  public function getClass(): string
  {
    return $this->class;
  }

  /** {@inheritdoc} */
  public function getSetting(string $name): SettingInterface
  {
    return $this->cache->fetch($this->createKey($name));
  }

  /** {@inheritdoc} */
  public function deleteSetting(SettingInterface $setting)
  {
    $this->unsetValue($setting->getName());
  }

  /** {@inheritdoc} */
  public function updateSetting(SettingInterface $setting)
  {
    $this->cache->save($this->createKey($name), $setting, $this->livetime);
  }

  /** {@inheritdoc} */
  public function unsetValue(string $name)
  {
    $this->cache->delete($this->createKey($name));
  }

  /**
   * Create key for storing in cache.
   * If you are using namespaces, tagging and so on, you should override it.
   *
   * @param string $name name of stored object
   * @return string $key key to store
   */
  protected function createKey(string $name): string
  {
    return $this->prefix . $name;
  }
}
