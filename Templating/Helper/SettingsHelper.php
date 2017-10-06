<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\Templating\Helper;

use Miky\Bundle\SettingsBundle\Manager\SettingsManagerInterface;
use Symfony\Component\Templating\Helper\Helper;

final class SettingsHelper extends Helper implements SettingsHelperInterface
{
    /**
     * @var SettingsManagerInterface
     */
    private $settingsManager;

    /**
     * @param SettingsManagerInterface $settingsManager
     */
    public function __construct(SettingsManagerInterface $settingsManager)
    {
        $this->settingsManager = $settingsManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getSettings($schemaAlias)
    {
        return $this->settingsManager->load($schemaAlias);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'miky_settings';
    }
}
