<?php

namespace RonteLtd\SettingsBundle\Model;

class Setting implements SettingInterface
{
  use SettingTrait;

  /** @var string */
  protected $name;
  /** @var string */
  protected $value;
  /** @var string */
  protected $type;

  /** {@inheritdoc} */
  public function setName(string $name)
  {
    $this->name = $name;
    return $this;
  }

  /** {@inheritdoc} */
  public function getName(): string
  {
    return $this->name;
  }

  /** {@inheritdoc} */
  public function setValue($value)
  {
    $this->value = $this->valueToString($value);
    return $this;
  }

  /** {@inheritdoc} */
  public function getValue()
  {
    return $this->stringToValue($this->value);
  }

  /** {@inheritdoc} */
  public function setType(string $type)
  {
    $this->type = $type;
    return $this;
  }

  /** {@inheritdoc} */
  public function getType(): string
  {
    return $this->type;
  }
}
