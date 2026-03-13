<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Builder\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/new', name: 'app_user_new')]
    public function new(): Response
    {
        return $this->render('user/new.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/create', name: 'app_user_create', methods: ['POST'])]
    public function create(ValidatorInterface $validator, EntityManagerInterface $entityManager, Request $request)
    {
        $user = new User();
        $user->setName($request->request->get('name'));
        $user->setEmail($request->request->get('email'));
        $user->setAge((int) $request->request->get('age'));
        $user->setStatus((bool) $request->request->get('status'));

        $errors = $validator->validate($user);

        if (count($errors) > 0) {

            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ' : ' . $error->getMessage();
            }

            return $this->render('user/new.html.twig', [
                'errors' => $errorMessages,
                'old' => $request->request->all()
            ]);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }
}
