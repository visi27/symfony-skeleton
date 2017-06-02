<?php

namespace AppBundle\Security\TwoFactor;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface HelperInterface
{
    public function is2faActive(UserInterface $user);
    public function checkCode(UserInterface $user, $code);
    public function getSessionKey(TokenInterface $token);
}