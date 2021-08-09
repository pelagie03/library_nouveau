<?php

namespace App\Form;

use App\Entity\Livres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, ['required' => true])
            ->add('auteur', TextType::class, ['required' => true])
            ->add('disponible', TextType::class, ['required' => true])
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
