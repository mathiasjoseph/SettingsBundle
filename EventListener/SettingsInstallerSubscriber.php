<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 26/11/16
 * Time: 04:06
 */

namespace Miky\Bundle\SettingsBundle\EventListener;



use Miky\Bundle\InstallerBundle\Event\InstallationEvent;
use Miky\Bundle\InstallerBundle\MikyInstallerEvents;
use Miky\Bundle\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SettingsInstallerSubscriber implements EventSubscriberInterface
{
    protected $settingsManager;

    /**
     * SettingsInstallerSubscriber constructor.
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }


    public static function getSubscribedEvents()
    {
        return array(
            MikyInstallerEvents::INSTALL_INITIALIZE => 'onInstallation',
        );
    }

    public function onInstallation(InstallationEvent $event)
    {
        $array = $this->settingsManager->getSchemaRegistry()->all();
        foreach ($array as $key => $object){
            $schemaAlias = $key;
            $schema = $this->settingsManager->load($schemaAlias);
            $this->settingsManager->save($schema);
        }
    }
}