<?php

namespace Lexik\Bundle\MailerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('lexik_mailer');

        $treeBuilder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('admin_email')
            ->isRequired()
            ->end()
            ->scalarNode('supported_locales')
            ->defaultValue('de en es')
            ->end()
            ->scalarNode('base_layout')
            ->cannotBeEmpty()
            ->defaultValue('LexikMailerBundle::layout.html.twig')
            ->end()

                ->integerNode('list_items_per_page')
                    ->defaultValue(20)
                ->end()

                ->arrayNode('templating_extensions')
                    ->defaultValue(array())
                    ->prototype('scalar')
                    ->end()
                ->end()

                ->arrayNode('allowed_headers')
                    ->defaultValue(array())
                    ->prototype('scalar')
                    ->end()
                ->end()

                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('email_entity')
                            ->cannotBeEmpty()
                            ->defaultValue('Lexik\Bundle\MailerBundle\Entity\Email')
                        ->end()
                        ->scalarNode('annotation_driver')
                            ->cannotBeEmpty()
                            ->defaultValue('Lexik\Bundle\MailerBundle\Mapping\Driver\Annotation')
                        ->end()
                        ->scalarNode('message_factory')
                            ->cannotBeEmpty()
                            ->defaultValue('Lexik\Bundle\MailerBundle\Message\MessageFactory')
                        ->end()
                        ->scalarNode('message_renderer')
                            ->cannotBeEmpty()
                            ->defaultValue('Lexik\Bundle\MailerBundle\Message\MessageRenderer')
                        ->end()
                        ->scalarNode('signer_factory')
                            ->cannotBeEmpty()
                            ->defaultValue('Lexik\Bundle\MailerBundle\Signer\SignerFactory')
                        ->end()
                        ->scalarNode('signer_dkim')
                            ->cannotBeEmpty()
                            ->defaultValue('Lexik\Bundle\MailerBundle\Signer\DkimSigner')
                        ->end()
                    ->end()
                ->end()

                ->scalarNode('signer')
                    ->defaultValue(null)
                ->end()

                ->arrayNode('dkim')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('private_key_path')
                            ->defaultValue('%kernel.project_dir%/config/dkim.key')
                        ->end()
                        ->scalarNode('domain')
                            ->defaultValue('localhost')
                        ->end()
                        ->scalarNode('selector')
                            ->defaultValue('selector')
                        ->end()
                    ->end()
                ->end()

                ->booleanNode('sonata_integration')
                    ->defaultFalse()
                ->end()

            ->end()
        ;

        return $treeBuilder;
    }
}
