<?php

namespace App\Form;

use App\Entity\Emprunt;
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
            ->add('adherent', CollectionType::class, [
                'entry_type' => AdherentType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'required' => true
            ])
            ->add('emprunts', CollectionType::class, [
                'entry_type' => LivresType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
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
