<?php

namespace App\Controller;

use App\Form\UpdateProfilType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function detailsProfil(int $id, EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher, SluggerInterface $slugger, UserRepository $userRepository,): Response
    {

        $user = $userRepository->find($id);

        $formUpdate = $this->createForm(UpdateProfilType::class, $user);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isSubmitted() && $formUpdate->isValid()) {
            $img = $formUpdate->get('image')->getData();
            if ($img) {
                $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $img->guessExtension();
                try {
                    $img->move($this->getParameter('images_directory'), $newFilename);
                    $user->setImage($newFilename);
                } catch (FileException $e) {
                    var_dump($e);
                }
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $formUpdate->get('plainPassword')->getData()
                    ));
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('main_home');
            }

        }
        return $this->render('/user/detailsProfil.html.twig', ['user' => $user, 'formUpdate' => $formUpdate]);
    }
}
