<?php

namespace App\Controller;

use App\Repository\Database\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RepositoryCacheController extends AbstractController
{
    public function __invoke(UserRepository $userRepository): Response
    {
        $user = $userRepository->getById(1);

        return new Response($user, Response::HTTP_OK);
    }
}