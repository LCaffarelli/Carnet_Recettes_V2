<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/recette/',name:'recette_')]
class RecetteController extends AbstractController
{
    #[Route('creerRecette', name: 'creerRecette')]
    public function creerRecette(): Response
    {
        $recette= new Recette();
       $recetteForm=$this->createForm(RecetteType::class,$recette);
        return $this->render('recette/creerRecette.html.twig', [
            'recette'=>$recette, 'recetteForm'=>$recetteForm->createView()
        ]);
    }
}
