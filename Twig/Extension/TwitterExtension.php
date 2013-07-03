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

class TwitterExtension extends \Twig_Extension
{
  protected $container;
  
  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   */
  
  public function __construct( ContainerInterface $container )
  {
    $this->container = $container;
  }
  
  public function getFunctions( )
  {
    return array( 
        'twitter_login_url' => new \Twig_Function_Method( $this, 'renderLoginUrl',
            array( 'is_safe' => array( 'html' ) )) );
  }
  
  public function renderLoginUrl( )
  {
    return $this->container->get( 'fos_twitter.twitter.helper' )->loginUrl( );
  }
  
  /**
   * @return string
   */
  
  public function getName( )
  {
    return 'twitter';
  }
}
