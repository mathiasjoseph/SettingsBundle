<?php

/*
 * This file is part of the Miky package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Miky\Bundle\SettingsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Registers all settings schemas in the schema registry.
 * Save the configuration names in parameter for the provider.
 *
 * @author Paweł Jędrzejewski <pawel@miky.org>
 */
class RegisterSchemasPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('miky.registry.settings_schema')) {
            return;
        }

        $schemaRegistry = $container->getDefinition('miky.registry.settings_schema');
        $taggedServicesIds = $container->findTaggedServiceIds('miky_settings_schema');

        foreach ($taggedServicesIds as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['alias'])) {
                    throw new \InvalidArgumentException(sprintf('Service "%s" must define the "alias" attribute on "miky.settings_schema" tags.', $id));
                }
                $schemaRegistry->addMethodCall('register', [$attributes['alias'], new Reference($id)]);
            }
        }
    }
}
