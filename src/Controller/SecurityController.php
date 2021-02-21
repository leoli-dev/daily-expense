<?php

namespace App\Controller;

use App\Model\User;
use App\Service\SecurityHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends AbstractController
{
    /**
     * @param Request $request
     * @param TokenStorageInterface $tokenStorage
     * @param SecurityHelper $securityHelper
     *
     * @return Response
     */
    public function login(
        Request $request,
        TokenStorageInterface $tokenStorage,
        SecurityHelper $securityHelper
    ): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }
        $error = null;
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        if (!empty($username) && !empty($password)) {
            if ($username === $securityHelper->getUsername() && $password === $securityHelper->getPassword()) {
                $user = new User($username);
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $tokenStorage->setToken($token);
                $request->getSession()->set('_security_main', serialize($token));

                return $this->redirectToRoute('app_dashboard');
            }

            $error = 'Invalid username or password.';
        }

        return $this->render(
            'security/login.html.twig',
            [
                'lastUsername' => $username,
                'error' => $error
            ]
        );
    }

    /**
     * Empty controller as logout has
     */
    public function logout()
    {
    }
}
