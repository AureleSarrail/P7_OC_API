<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="login")
     * @return JsonResponse
     */
    public function api_login()
    {
        $user = $this->getUser();

        return new JsonResponse($user,200);
    }
}
