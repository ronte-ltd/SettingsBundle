<?php

namespace RonteLtd\SettingsBundle\Entity;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use RonteLtd\SettingsBundle\Model\SettingManager as BaseSettingManager;
use RonteLtd\SettingsBundle\Model\SettingInterface;

class SettingManager extends BaseSettingManager
{
  /** @var EntityManager */
  protected $em;

  /** @var EntityRepository */
  protected $repository;

  /** @var string */
  protected $class;

  public function __construct(ObjectManager $em, string $class)
  {
    $this->em = $em;
    $this->repository = $em->getRepository($class);
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
  public function deleteSetting(SettingInterface $setting)
  {
    $this->em->remove($setting);
    $this->em->flush();
  }

  /** {@inheritdoc} */
  public function updateSetting(SettingInterface $setting)
  {
    $this->em->persist($setting);
    $this->em->flush();
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
  public function unsetValue(string $name)
  {
    $this->repository->createQueryBuilder()
      ->delete()
      ->where('name = ?1')
      ->setParameters([1 => $name])
      ->getQuery()->execute();
  }
}
