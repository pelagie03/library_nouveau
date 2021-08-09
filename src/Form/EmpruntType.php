<?php

namespace App\Form;

use App\Entity\Adherent;
use App\Entity\Emprunt;
use App\Entity\Livres;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adherent', EntityType::class, [
                'class' => Adherent::class,
                'choice_label' => 'nom',
                'required' => true
            ])
            ->add('emprunts', EntityType::class, [
                'class' => Livres::class,
                'choice_label' => 'titre',
                'required' => true
            ])
            ->add('dateEmp', DateType::class, ['required' => true])
            ->add('dateRet', DateType::class, ['required' => true])
            ->add('save', SubmitType::class, [
                'label' => "Enregistrer",
                'attr' => ['class' => 'btn btn-square btn-success']
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
