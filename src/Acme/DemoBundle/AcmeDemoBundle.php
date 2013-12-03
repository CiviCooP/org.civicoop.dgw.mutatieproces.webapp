<?php

namespace Acme\DemoBundle;

use Acme\DemoBundle\DependencyInjection\Security\Factory\WsseFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AcmeDemoBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new WsseFactory());
    }
}
