<?php

/*
 * This file is part of the FOSTwitterBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\TwitterBundle\Templating\Helper;
use Symfony\Component\Templating\Helper\Helper;

class TwitterHelper extends Helper
{
  protected $twitter;
  
  public function __construct( $twitter )
  {
    $this->twitter = $twitter;
  }
  
  public function loginUrl( )
  {
    return $this->twitter->getLoginUrl( );
  }
  
  /**
   * @codeCoverageIgnore
   */
  
  public function getName( )
  {
    return 'twitter';
  }
}
