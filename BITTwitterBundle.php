<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use BIT\TwitterBundle\DependencyInjection\Security\Factory\TwitterFactory;

class BITTwitterBundle extends Bundle
{
  
  public function build( ContainerBuilder $container )
  {
    parent::build( $container );
    
    $extension = $container->getExtension( 'security' );
    $extension->addSecurityListenerFactory( new TwitterFactory( ) );
  }
}
