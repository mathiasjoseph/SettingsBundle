<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 02/10/16
 * Time: 15:32
 */

namespace Miky\Bundle\SettingsBundle\Installer;


use Miky\Bundle\InstallerBundle\Model\InstallerInterface;
use Miky\Bundle\SettingsBundle\Manager\SettingsManager;

class SettingsInstaller implements InstallerInterface
{
    protected $settingsManager;

    /**
     * LocationInstaller constructor.
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    public function run(){
       $array = $this->settingsManager->getSchemaRegistry()->all();
        foreach ($array as $key => $object){
            $schemaAlias = $key;
            $schema = $this->settingsManager->load($schemaAlias);
            $this->settingsManager->save($schema);
        }
    }
}