<?php

namespace CiviCoop\InsiteAuthenticatorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CiviCoop\InsiteAuthenticatorBundle\DependencyInjection\Security\Factory\InsiteFactory;

class CiviCoopInsiteAuthenticatorBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new InsiteFactory());
	}
}
