<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\Event;

use Miky\Bundle\SettingsBundle\Model\SettingsInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Aram Alipoor <aram.alipoor@gmail.com>
 * @author Steffen Brem <steffenbrem@gmail.com>
 */
class SettingsEvent extends Event
{
    const PRE_SAVE = 'miky.settings.pre_save';
    const POST_SAVE = 'miky.settings.post_save';

    /**
     * @var SettingsInterface
     */
    private $settings;

    /**
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return SettingsInterface
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param SettingsInterface $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }
}
