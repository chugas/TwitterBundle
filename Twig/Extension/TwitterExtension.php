<?php
/**
 * Created by Amal Raghav <amal.raghav@gmail.com>
 * Date: 05/03/11
 */

namespace FOS\TwitterBundle\Twig\Extension;
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
