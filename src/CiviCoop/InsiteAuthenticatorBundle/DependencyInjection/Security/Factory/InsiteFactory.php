<?php

namespace CiviCoop\InsiteAuthenticatorBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class InsiteFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        /*$providerId = 'security.authentication.provider.insite.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('insite.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
        ;

        $listenerId = 'security.authentication.listener.insite.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('insite.security.authentication.listener'));

        return array($providerId, $listenerId, $defaultEntryPoint);*/
		
		$providerId = 'security.authentication.provider.insite.'.$id;
        $providerDD = new DefinitionDecorator(
                          'insite.security.authentication.provider');

        $container->setDefinition($providerId, $providerDD);

        $listenerId = 'security.authentication.listener.insite.'.$id;
        $listenerDD = new DefinitionDecorator(
                              'insite.security.authentication.listener');
        $listener = $container->setDefinition($listenerId, $listenerDD);
		

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'insite';
    }

    public function addConfiguration(NodeDefinition $node)
    {
    }
}