<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Mesure;
use App\Entity\Met;
use App\Entity\Methode;
use App\Entity\Recette;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('met', EntityType::class, ['class' => Met::class,'choice_label' => 'nom', 'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')->orderBy('m.nom', order: 'ASC');}])
                ->add('methodes', EntityType::class,['class'=>Methode::class])
            ->add('ingredients',EntityType::class,['class'=>Ingredient::class])
            ->add('mesures',EntityType::class,['class'=>Mesure::class])
            ->add('user',EntityType::class,['class'=>User::class]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}
