<?php

namespace App\Form;

use App\Entity\Livres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\{ChoiceType, TextType, SubmitType};

class LivresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['required' => true])
            ->add('auteur', TextType::class, ['required' => true])
            ->add('disponible', ChoiceType::class, [
                'required' => true,
                'label' => "Disponible ?",
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => "Enregistrer",
                'attr' => ['class' => 'btn btn-square btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livres::class,
        ]);
    }
}
