<?php

/**
 * (c) Evis Bregu <evis.bregu@gmail.com>.
 */

namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityRepository
     */
    private $userRepository;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * LoginFormAuthenticator constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param EntityRepository $userRepository
     * @param RouterInterface $router
     * @param UserPasswordEncoder $passwordEncoder
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EntityRepository $userRepository,
        RouterInterface $router,
        UserPasswordEncoder $passwordEncoder
    ) {
        $this->formFactory = $formFactory;
        $this->userRepository = $userRepository;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getCredentials(Request $request)
    {
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        $data = $form->getData();

        if ($request->getSession()) {
            $request->getSession()->set(
                Security::LAST_USERNAME,
                $data['_username']
            );
        }


        return $data;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $username = $credentials['_username'];

        return $this->userRepository->findOneBy(['email' => $username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $password = $credentials['_password'];
        if ($this->passwordEncoder->isPasswordValid($user, $password)) {
            return true;
        }

        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // if the user hits a secure page and start() was called, this was
        // the URL they were on, and probably where you want to redirect to
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);

        if (!$targetPath) {
            $targetPath = $this->router->generate('homepage');
        }

        return new RedirectResponse($targetPath);
    }

    public function supports(Request $request)
    {
        return ($request->getPathInfo() === '/login' && $request->isMethod('POST'));
    }
}
