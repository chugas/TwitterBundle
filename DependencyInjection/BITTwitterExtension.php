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
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BITTwitterExtension extends Extension
{
  protected $resources = array( 'twitter' => 'twitter.xml', 'security' => 'security.xml', );
  
  public function load( array $configs, ContainerBuilder $container )
  {
    $processor = new Processor( );
    $configuration = new Configuration( );
    $config = $processor->processConfiguration( $configuration, $configs );
    
    $this->loadDefaults( $container );
    
    if ( isset( $config[ 'alias' ] ) )
      $container->setAlias( $config[ 'alias' ], 'bit_twitter.service' );
    
    $attributes = array( 'file', 'consumer_key', 'consumer_secret', 'callback_url', 'access_token',
        'access_token_secret', 'anywhere_version' );
    foreach ( $attributes as $attribute )
      if ( isset( $config[ $attribute ] ) )
        $container->setParameter( 'bit_twitter.' . $attribute, $config[ $attribute ] );
    
    if ( !empty( $config[ 'callback_route' ] ) )
      $container->getDefinition( 'bit_twitter.service' )
          ->addMethodCall( 'setCallbackRoute', array( new Reference( 'router'), $config[ 'callback_route' ], ) );
  }
  
  protected function loadDefaults( $container )
  {
    $loader = new XmlFileLoader( $container,
        new FileLocator( array( __DIR__ . '/../Resources/config', __DIR__ . '/Resources/config' )));
    
    foreach ( $this->resources as $resource )
      $loader->load( $resource );
  }
}
