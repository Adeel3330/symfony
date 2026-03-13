<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'age' => 30,
                'status' => 'active',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'jane@gmail.com',
                'age' => '25',
                'status' => 'inactive',
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob@gmail.com',
                'age' => 35,
                'status' => 'active',
            ],
        ];
        return $this->render('home/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/show/{id}', name: 'app_show')]
    public function show($id)
    {
        return $this->render('home/show.html.twig', [
            'id' => $id,
        ]);
    }
}
