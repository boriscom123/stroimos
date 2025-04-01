<?php
namespace AppBundle\Security;

use Application\Sonata\UserBundle\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;

class OAuthFOSUBUserProvider extends FOSUBUserProvider
{
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();

        if (null === $username) {
            throw new AccountNotLinkedException(sprintf("Пользователь '%s' не найден.", $username));
        }

        $tmpUser = $this->fillUserFromUserResponse($this->userManager->createUser(), $response);

        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $response->getUsername()));
        if (null === $user) {
            $user = $this->userManager->findUserByEmail($tmpUser->getEmail());
        }

        if ($user !== null && !$user instanceof User) {
            throw new AccountNotLinkedException("Ошибка входа.");
        }

        if (null === $user) {
            $user = $this->userManager->createUser();
        }

        if ($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN') || $user->hasRole('ROLE_SONATA_ADMIN')) {
            throw new AccountNotLinkedException("Ошибка входа. Вход возможен только используя имя пользователя и пароль.");
        }

        $user = $this->fillUserFromUserResponse($user, $response);
        $this->userManager->updateUser($user);

        return $user;
    }

    protected function fillUserFromUserResponse(User $user, UserResponseInterface $response)
    {
        $fillUserMethod = 'fillUserFrom'. ucfirst($response->getResourceOwner()->getName()) .'Response';

        if (!method_exists($this, $fillUserMethod)) {
            throw new AccountNotLinkedException("Ошибка создания пользователя для социальной сети.");
        }

        $user->setEnabled(true);
        $user->setPlainPassword(uniqid('uniqid', true) . uniqid('uniqid', true));

        $this->$fillUserMethod($user, $response);

        return $user;
    }

    protected function fillUserFromFacebookResponse(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();

        $user->setFacebookUid($response->getUsername());
        $user->setUsername($response->getEmail());
        $user->setEmail($response->getEmail());
        $user->setFirstName($responseArray['first_name']);
        $user->setLastname($responseArray['last_name']);
    }

    protected function fillUserFromGoogleResponse(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();

        $user->setGplusUid($response->getUsername());
        $user->setUsername($response->getEmail());
        $user->setEmail($response->getEmail());
        $user->setFirstName($responseArray['given_name']);
        $user->setLastname($responseArray['family_name']);
    }

    protected function fillUserFromVkontakteResponse(User $user, UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();
        $responseArray = $responseArray['response'][0];

        $user->setVkontakteUid($response->getUsername());

        $username = $response->getEmail() ?: $response->getUsername();
        $user->setUsername($username);

        $email = $response->getEmail() ?: $response->getUsername() . '@vk.com';
        $user->setEmail($email);

        $user->setFirstName($responseArray['first_name']);
        $user->setLastname($responseArray['last_name']);
    }

    protected function fillUserFromLogin_mos_ruResponse(User $user, UserResponseInterface $response)
    {
        $email = $response->getEmail();

        if (empty($email)) {
            $email = $response->getNickname() . '@login.mos.ru';
        }

        $user->setLoginMosUid($response->getUsername());
        $user->setUsername($email);
        $user->setEmail($email);
        $user->setFirstName($response->getFirstName());
        $user->setLastname($response->getLastName());
    }
}
