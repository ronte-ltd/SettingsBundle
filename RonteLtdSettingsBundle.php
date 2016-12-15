<?php

namespace RonteLtd\SettingsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use RonteLtd\SettingsBundle\DependencyInjection\RonteltdSettingsExtension;

class RonteLtdSettingsBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new RonteltdSettingsExtension();
    }
}
