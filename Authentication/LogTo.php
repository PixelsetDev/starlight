<?php

namespace Starlight\Authentication;

use JetBrains\PhpStorm\NoReturn;
use Logto\Sdk\InteractionMode;
use Logto\Sdk\LogtoClient;
use Logto\Sdk\LogtoConfig;
use Logto\Sdk\LogtoException;
use Logto\Sdk\Models\IdTokenClaims;
use Logto\Sdk\Oidc\UserInfoResponse;
use Throwable;

class LogTo
{
    private LogtoClient $client;

    public function __construct(
        string $endpoint,
        string $appId,
        string $appSecret,
        array $scopes
    ) {
        $this->client = new LogtoClient(
            new LogtoConfig(
                endpoint: $endpoint,
                appId: $appId,
                appSecret: $appSecret,
                scopes: $scopes
            ),
        );
    }

    /**
     * Sends the user to the sign in page.
     * @param string $redirectURI The URI to redirect the user to after sign in (usually callback).
     * @return void
     */
    public function signIn(string $redirectURI): void
    {
        header('Location: '.$this->client->signIn($redirectURI, InteractionMode::signIn));
        exit;
    }

    /**
     * Sends the user to the signup page.
     * @param string $redirectURI The URI to redirect the user to after sign up.
     * @return void
     */
    #[NoReturn]
    public function signUp(string $redirectURI): void
    {
        header('Location: '.$this->client->signIn($redirectURI, InteractionMode::signUp));
        exit;
    }

    /**
     * Signs the user out
     * @param string $redirectURI The URI to redirect the user to.
     * @return void
     * @throws LogtoException
     */
    #[NoReturn]
    public function signOut(string $redirectURI): void
    {
        header('Location: '.$this->client->signOut($redirectURI));
        exit;
    }

    /**
     * @param string $redirectURI The URI to redirect the user to.
     * @return mixed Nothing or a throwable
     */
    public function callback(string $redirectURI): mixed
    {
        try {
            $this->client->handleSignInCallback();
        } catch (Throwable $exception) {
            return $exception;
        }

        header('Location: '.$redirectURI);
        exit;
    }

    /**
     * Checks if the user is authenticated.
     * @return bool If the user is authenticated.
     */
    public function isAuthenticated(): bool
    {
        return $this->client->isAuthenticated();
    }

    /**
     * Gets the user's IdTokenClaims.
     * @return IdTokenClaims
     */
    public function getUserTokenClaims(): IdTokenClaims
    {
        return $this->client->getIdTokenClaims();
    }

    /**
     * Gets the user's account information.
     * @throws LogtoException
     */
    public function getUserInfo(): UserInfoResponse|null
    {
        if ($this->isAuthenticated()) {
            return $this->client->fetchUserInfo();
        }

        return null;
    }
}