<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 19/05/17
 * Time: 17:15
 */

namespace Miky\Bundle\SettingsBundle\EventListener;


use Miky\Bundle\AdminBundle\Menu\AdminMenuBuilder;
use Miky\Bundle\MenuBundle\Event\MenuBuilderEvent;
use Miky\Bundle\SettingsBundle\Manager\SettingsManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SettingsMenuSubscriber implements EventSubscriberInterface
{
    /**
     * @var SettingsManager
     */
    private $settingsManager;

    /**
     * SettingsMenuSubscriber constructor.
     * @param SettingsManager $settingsManager
     */
    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }


    public static function getSubscribedEvents()
    {
        return array(
            AdminMenuBuilder::EVENT_NAME => 'onAdminMenu',
        );
    }

    public function onAdminMenu(MenuBuilderEvent $event)
    {
        $menu = $event->getMenu();

        $schemas = $this->settingsManager->getSchemaRegistry()->all();
        $settingsMenu = $menu
            ->addChild('settings')
            ->setLabel('Paramètres')
            ->setLabelAttribute('icon', 'calendar-check-o')
        ;
        foreach ($schemas as $key => $value){
            $settingsMenu
                ->addChild("settings_".$key, ['route' => 'miky_admin_settings_edit', 'routeParameters' => array('schema' => $key)])
                ->setLabel("miky.ui.".$key)
                ->setLabelAttribute('icon', 'calendar-check-o')
            ;
        }

    }
}