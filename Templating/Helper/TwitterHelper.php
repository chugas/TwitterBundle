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
