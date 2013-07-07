<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle\DependencyInjection\Security\Factory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class TwitterFactory extends AbstractFactory
{
  
  public function __construct( )
  {
    $this->addOption( 'create_user_if_not_exists', false );
  }
  
  public function getPosition( )
  {
    return 'pre_auth';
  }
  
  public function getKey( )
  {
    return 'bit_twitter';
  }
  
  protected function getListenerId( )
  {
    return 'bit_twitter.security.authentication.listener';
  }
  
  protected function createAuthProvider( ContainerBuilder $container, $id, $config, $userProviderId )
  {
    $authProviderId = 'bit_twitter.auth.' . $id;
    
    $definitionDecorator = new DefinitionDecorator( 'bit_twitter.auth');
    $definition = $container->setDefinition( $authProviderId, $definitionDecorator );
    $definition->replaceArgument( 0, $id );
    
    // with user provider
    if ( isset( $config[ 'provider' ] ) )
    {
      $definition->addArgument( new Reference( $userProviderId) );
      $definition->addArgument( new Reference( 'security.user_checker') );
      $definition->addArgument( $config[ 'create_user_if_not_exists' ] );
    }
    
    return $authProviderId;
  }
  
  protected function createEntryPoint( $container, $id, $config, $defaultEntryPointId )
  {
    $entryPointId = 'bit_twitter.security.authentication.entry_point.' . $id;
    $definitionDecorator = new DefinitionDecorator( 'bit_twitter.security.authentication.entry_point');
    $container->setDefinition( $entryPointId, $definitionDecorator );
    
    // set options to container for use by other classes
    $container->setParameter( 'bit_twitter.options.' . $id, $config );
    
    return $entryPointId;
  }
}
