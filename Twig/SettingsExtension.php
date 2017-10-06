<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\Twig;

use Miky\Bundle\SettingsBundle\Templating\Helper\SettingsHelperInterface;


final class SettingsExtension extends \Twig_Extension
{
    /**
     * @var SettingsHelperInterface
     */
    private $helper;

    /**
     * @param SettingsHelperInterface $helper
     */
    public function __construct(SettingsHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
             new \Twig_SimpleFunction('miky_settings', [$this->helper, 'getSettings']),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'miky_settings';
    }
}
