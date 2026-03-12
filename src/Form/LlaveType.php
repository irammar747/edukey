<?php

namespace App\Form;

use App\Entity\Llave;
use App\Entity\Recurso;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LlaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo')
            ->add('descripcion')
            ->add('ubicacion')
            ->add('disponible')
            ->add('recursos', EntityType::class, [
                'class' => Recurso::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                'attr' => ['class' => 'select-recursos'] // Le damos una clase para JS
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Llave::class,
        ]);
    }
}
