<?php

namespace RonteLtd\SettingsBundle\Model;

abstract class SettingManager implements SettingManagerInterface
{
    /** {@inheritdoc} */
    public function createSetting(): SettingInterface
    {
        $class = $this->getClass();
        return new $class();
    }

    /** {@inheritdoc} */
    public function setValue(string $name, $value, string $type = null)
    {
        $type = $this->detectType($value, $type);
        $setting = $this->createSetting()
            ->setName($name)
            ->setValue($value)
            ->setType($type);

        $this->updateSetting($setting);
    }

    /** {@inheritdoc} */
    public function getValue(string $name, $default = null)
    {
        $instance = $this->getSetting($name);
        if ($instance) {
            return $instance->getValue();
        }

        return $default;
    }

    /** {@inheritdoc} */
    public function getType(string $name)
    {
        $instance = $this->getSetting($name);
        if ($instance) {
            return $instance->getType();
        }
    }

    /**
     * Internal function for detecting type in setValue.
     *
     * @param mixed $value
     * @param mixed $type must be null or string containing type
     * @return string
     */
    protected function detectType($value, $type): string
    {
        if (is_string($type) && $type !== '') {
            return $type;
        }
        return gettype($value);
    }
}
