<?php


namespace KS\RoleRightBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KSRoleRightExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Load the config xml files into the bundle
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // Get configuration from the yaml file (ks_role_right). In there are the values the user set.
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        // Set arguments for the service.
        $definition = $container->getDefinition('ks_role_right.ks_command_helper');
        $definition->setArgument(0, $config['app_directory']);
    }
}