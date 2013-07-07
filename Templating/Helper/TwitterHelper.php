<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle\Templating\Helper;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\EngineInterface;
use Twitter_Client;

class TwitterHelper extends Helper
{
  protected $templating;
  protected $twitter;
  
  public function __construct( EngineInterface $templating, Twitter_Client $twitter )
  {
    $this->templating = $templating;
    $this->twitter = $twitter;
  }
  
  public function loginButton( )
  {
    return $this->templating->render( "BITTwitterBundle::loginButton.html.twig" );
  }
  
  public function loginUrl( )
  {
    return $this->twitter->createAuthUrl( );
  }
  
  public function getName( )
  {
    return 'twitter';
  }
}
