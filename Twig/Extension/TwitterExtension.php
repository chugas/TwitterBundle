<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle\Twig\Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;
use BIT\TwitterBundle\Templating\Helper\TwitterHelper;

class TwitterExtension extends \Twig_Extension
{
  protected $container;
  
  public function __construct( ContainerInterface $container )
  {
    $this->container = $container;
  }
  
  public function getFunctions( )
  {
    $functions = array( );
    $functions[ 'twitter_login_button' ] = new \Twig_Function_Method( $this, 'renderLoginButton');
    $functions[ 'twitter_login_url' ] = new \Twig_Function_Method( $this, 'renderLoginUrl');
    return $functions;
  }
  
  private function helper( )
  {
    return $helper = $this->container->get( 'bit_twitter.helper' );
  }
  
  public function renderLoginButton( )
  {
    return $this->helper( )->loginButton( );
  }
  
  public function renderLoginUrl( )
  {
    return $this->helper( )->loginUrl( );
  }
  
  public function getName( )
  {
    return 'twitter';
  }
}
