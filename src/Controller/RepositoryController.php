<?php

namespace App\Controller;

use App\Repository\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RepositoryController extends AbstractController
{
    public function __invoke(UserRepositoryInterface $userRepository): Response
    {
        $user = $userRepository->getById(1);

        return new Response($user, Response::HTTP_OK);
    }
}