<?php

/*
 * This file is part of the BITTwitterBundle package.
*
* (c) bitgandtter <http://bitgandtter.github.com/>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/
namespace BIT\TwitterBundle\Security\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

interface UserManagerInterface extends UserProviderInterface
{
  
  /**
   * Creates a user for the given access token.
   *
   * @param array $token
   * @return UserInterface
   */
  function createUserFromAccessToken( array $token );
}
