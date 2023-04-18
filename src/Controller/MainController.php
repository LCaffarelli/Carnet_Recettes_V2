<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/', name: 'main_')]
class MainController extends AbstractController
{
    #[Route('accueil', name: 'home')]
    public function home(UserRepository $userRepository): Response
    {
        $user=$userRepository->find($this->getUser()->getId());
        return $this->render('main/home.html.twig',['user'=>$user]);
    }
}
