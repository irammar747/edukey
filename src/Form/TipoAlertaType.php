<?php

namespace App\Form;

use App\Entity\TipoAlerta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TipoAlertaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nombre'
            ])
            ->add('mensaje')
            ->add('gravedad', ChoiceType::class, [
                'choices'  => [
                    'Baja' => 'Baja',
                    'Media' => 'Media',
                    'Alta' => 'Alta',
                    'Crítica' => 'Crítica',
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => ['class' => 'd-none'],
                'label' => false
            ])
            ->add('consecuencia')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TipoAlerta::class,
        ]);
    }
}
