<?php

namespace RonteLtd\SettingsBundle\CouchDocument;

use Doctrine\ODM\CouchDB\DocumentManager;
use Doctrine\ODM\CouchDB\DocumentRepository;

use RonteLtd\SettingsBundle\Model\SettingInterface;
use RonteLtd\SettingsBundle\Model\SettingManager as BaseSettingManager;

class SettingManager extends BaseSettingManager
{
    /** @var DocumentManager */
    protected $dm;

    /** @var DocumentRepository */
    protected $repository;

    /** @var string */
    protected $class;

    public function __construct(DocumentManager $dm, string $class)
    {
        $this->dm = $dm;
        $this->repository = $dm->getRepository($class);
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
        return $this->repository->findOneByName($name);
    }

    /** {@inheritdoc} */
    public function updateSetting(SettingInterface $setting)
    {
        $this->dm->persist($setting);
        $this->dm->flush();
    }

    /** {@inheritdoc} */
    public function deleteSetting(SettingInterface $setting)
    {
        $this->dm->remove($setting);
        $this->dm->flush();
    }

    public function unsetValue(string $value)
    {
        $setting = $this->createSetting()
            ->setName($name);

        $this->deleteSetting($setting);
    }
}
