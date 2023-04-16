<?php

namespace App\Controller;

use App\Repository\UserRepository;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/user/', name: 'user_')]
class UserController extends AbstractController
{
//    #[Route('/modifierProfil', name: 'modifProfil')]
//    public function modificationProfil(): Response
//    {
//        return $this->render('user/modifProfil.html.twig', [
//            'user' => $user,'formUpdate'=>$formUpdate->createView(),
//        ]);
//    }
    #[Route('/detailsProfil/{id}', name: 'detailsProfil')]
    public function detailsProfil(int $id, UserRepository $userRepository, ): Response{

        $user=$userRepository->find($id);
        return $this->render('/user/detailsProfil.html.twig', ['user'=>$user]);
    }
}
