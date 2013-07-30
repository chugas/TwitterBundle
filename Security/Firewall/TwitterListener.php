<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle\Security\Firewall;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\HttpFoundation\Request;
use BIT\TwitterBundle\Security\Authentication\Token\TwitterUserToken;

/**
 * Twitter authentication listener.
 */
class TwitterListener extends AbstractAuthenticationListener
{
  
  protected function attemptAuthentication( Request $request )
  {
    $request->getSession( )->set( "oauth_verifier", $request->get( "oauth_verifier" ) );
    return $this->authenticationManager->authenticate( new TwitterUserToken( $this->providerKey) );
  }
}
