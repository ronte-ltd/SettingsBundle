<?php

namespace RonteLtd\SettingsBundle\Model;

interface SettingInterface
{
    /**
     * Set setting's name.
     *
     * @param string $name
     * @return static
     */
    public function setName(string $name);

    /**
     * Get setting's name.
     *
     * @return string $name
     */
    public function getName(): string;

    /**
     * Set setting's value.
     *
     * @param mixed $value
     * @return static
     */
    public function setValue($value);

    /**
     * Get setting's value.
     *
     * @return mixed $value
     */
    public function getValue();

    /**
     * Set setting's type.
     *
     * @param string $type
     * @return static
     */
    public function setType(string $type);

    /**
     * Get setting's type.
     *
     * @return string $type
     */
    public function getType(): string;
}
