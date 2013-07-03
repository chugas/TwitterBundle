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
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  /**
   * Generates the configuration tree.
   *
   * @return TreeBuilder
   */
  
  public function getConfigTreeBuilder( )
  {
    $treeBuilder = new TreeBuilder( );
    $rootNode = $treeBuilder->root( 'bit_twitter' );
    
    $rootNode->validate( )
        ->always( 
            function ($v)
            {
              if ( !empty( $v[ 'callback_url' ] ) && !empty( $v[ 'callback_route' ] ) )
              {
                throw new \Exception( 'You cannot configure a "callback_url", and a "callback_route" at the same time.');
              }
              
              return $v;
            } )->end( )->children( )->scalarNode( 'file' )
        ->defaultValue( '%kernel.root_dir%/../vendor/twitteroauth/twitteroauth/twitteroauth.php' )->end( )
        ->scalarNode( 'consumer_key' )->isRequired( )->cannotBeEmpty( )->end( )->scalarNode( 'consumer_secret' )
        ->isRequired( )->cannotBeEmpty( )->end( )->scalarNode( 'access_token' )->defaultNull( )->end( )
        ->scalarNode( 'access_token_secret' )->defaultNull( )->end( )->scalarNode( 'callback_url' )->defaultNull( )
        ->end( )->scalarNode( 'callback_route' )->defaultNull( )->end( )->scalarNode( 'anywhere_version' )
        ->defaultValue( '1' )->end( )->scalarNode( 'alias' )->defaultNull( )->end( )->end( );
    
    return $treeBuilder;
  }
  
}

