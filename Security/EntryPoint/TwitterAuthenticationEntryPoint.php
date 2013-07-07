<?php

/*
 * This file is part of the BITTwitterBundle package.
 *
 * (c) bitgandtter <http://bitgandtter.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace BIT\TwitterBundle\Security\EntryPoint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * TwitterAuthenticationEntryPoint starts an authentication via Twitter.
 *
 */
class TwitterAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
  protected $twitterApi;
  
  public function __construct( \apiClient $twitterApi )
  {
    $this->twitterApi = $twitterApi;
  }
  
  /**
   * {@inheritdoc}
   */
  
  public function start( Request $request, AuthenticationException $authException = null )
  {
    return new RedirectResponse( $this->twitterApi->createAuthUrl( ));
  }
}
