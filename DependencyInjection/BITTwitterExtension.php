<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BIT\TwitterBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BITTwitterExtension extends Extension
{
  
  public function load( array $configs, ContainerBuilder $container )
  {
    $processor = new Processor( );
    $configuration = new Configuration( );
    $config = $processor->processConfiguration( $configuration, $configs );
    
    $this->loadDefaults( $container );
    
    foreach ( array( 'api', 'helper', 'twig' ) as $attribute )
      $container->setParameter( 'bit_twitter.' . $attribute . '.class', $config[ 'class' ][ $attribute ] );
    
    foreach ( array( 'consumer_key', 'consumer_secret', 'access_token', 'access_token_secret', 'callback_url',
        'callback_route' ) as $attribute )
      $container->setParameter( 'bit_twitter.' . $attribute, $config[ $attribute ] );
  }
  
  protected function loadDefaults( $container )
  {
    $loader = new XmlFileLoader( $container, new FileLocator( __DIR__ . '/../Resources/config'));
    
    foreach ( array( 'twitter' => 'twitter.xml', 'security' => 'security.xml' ) as $resource )
    {
      $loader->load( $resource );
    }
  }
}
