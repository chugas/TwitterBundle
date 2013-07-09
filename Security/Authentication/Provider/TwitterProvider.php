<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle\Security\Authentication\Provider;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use BIT\TwitterBundle\Security\User\UserManagerInterface;
use BIT\TwitterBundle\Security\Authentication\Token\TwitterUserToken;

class TwitterProvider implements AuthenticationProviderInterface
{
  protected $twitter;
  protected $providerKey;
  protected $userProvider;
  protected $userChecker;
  protected $createIfNotExists;
  private $oauth_verifier;
  
  public function __construct( $providerKey, $twitter, $userProvider = null, $userChecker = null,
      $createIfNotExists = false )
  {
    $errorMessage = '$userChecker cannot be null, if $userProvider is not null.';
    if ( null !== $userProvider && null === $userChecker )
      throw new \InvalidArgumentException( $errorMessage);
    
    $errorMessage = 'The $userProvider must implement UserManagerInterface if $createIfNotExists is true.';
    if ( $createIfNotExists && !$userProvider instanceof UserManagerInterface )
      throw new \InvalidArgumentException( $errorMessage);
    
    $this->providerKey = $providerKey;
    $this->twitter = $twitter;
    $this->userProvider = $userProvider;
    $this->userChecker = $userChecker;
    $this->createIfNotExists = $createIfNotExists;
  }
  
  public function authenticate( TokenInterface $token )
  {
    if ( !$this->supports( $token ) )
      return null;
    
    $this->twitter->authenticate( );
    
    $user = $token->getUser( );
    
    if ( $user instanceof UserInterface )
    {
      $this->userChecker->checkPostAuth( $user );
      
      $newToken = new TwitterUserToken( $this->providerKey, $user, $user->getRoles( ));
      $newToken->setAttributes( $token->getAttributes( ) );
      
      return $newToken;
    }
    
    try
    {
      $userData = $this->twitter->account_verifyCredentials( );
      if ( $uid = $userData->id )
      {
        $newToken = $this->createAuthenticatedToken( $uid );
        $newToken->setAttributes( $token->getAttributes( ) );
        
        return $newToken;
      }
      
      throw new AuthenticationException( 'The Twitter user could not be retrieved from the session.');
    }
    catch ( AuthenticationException $failed )
    {
      throw $failed;
    }
    catch ( \Exception $failed )
    {
      throw new AuthenticationException( $failed->getMessage( ), ( int ) $failed->getCode( ), $failed);
    }
  }
  
  public function supports( TokenInterface $token )
  {
    return $token instanceof TwitterUserToken && $this->providerKey === $token->getProviderKey( );
  }
  
  protected function createAuthenticatedToken( $uid )
  {
    if ( null === $this->userProvider )
      return new TwitterUserToken( $this->providerKey, $uid);
    
    try
    {
      $user = $this->userProvider->loadUserByUsername( $uid );
      $this->userChecker->checkPostAuth( $user );
    }
    catch ( UsernameNotFoundException $ex )
    {
      if ( !$this->createIfNotExists )
        throw $ex;
      
      $user = $this->userProvider->createUserFromUid( $uid );
    }
    
    if ( !$user instanceof UserInterface )
      throw new \RuntimeException( 'User provider did not return an implementation of user interface.');
    
    return new TwitterUserToken( $this->providerKey, $user, $user->getRoles( ));
  }
}
