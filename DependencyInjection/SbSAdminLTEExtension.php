<?php

namespace SbS\AdminLTEBundle\DependencyInjection;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SbSAdminLTEExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');

        if (class_exists(Application::class)) {
            $loader->load('console.xml');
        }
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (isset($bundles['TwigBundle'])) {
            $container->prependExtensionConfig(
                'twig', [
                    'form_themes' => ['bootstrap_3_layout.html.twig'],
                ]
            );
        }

        if (isset($bundles['AsseticBundle'])) {
            $container->prependExtensionConfig(
                'assetic', [
                    'bundles' => ['SbSAdminLTEBundle'],
                    'assets'  => [
                        'bootstrap_min_css_map' => [
                            'inputs' => ['%kernel.root_dir%/../web/components/bootstrap/css/bootstrap.min.css.map'],
                            'output' => 'css/bootstrap.min.css.map',
                        ],
                    ],
                ]
            );
        }
    }
}
