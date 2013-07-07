<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle\Security\Logout;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

/**
 * Listener for the logout action
 *
 * This handler will clear the application's Twitter cookie.
 */
class TwitterHandler implements LogoutHandlerInterface
{
  private $twitterApi;
  
  public function __construct( \apiClient $twitterApi )
  {
    $this->twitterApi = $twitterApi;
  }
  
  public function logout( Request $request, Response $response, TokenInterface $token )
  {
    $response->headers->clearCookie( 'gsr_' . $this->twitterApi->getAppId( ) );
  }
}
