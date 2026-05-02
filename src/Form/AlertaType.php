<?php

namespace App\Form;

use App\Entity\Alerta;
use App\Entity\Prestamo;
use App\Entity\TipoAlerta;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlertaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('tipoAlerta', EntityType::class, [
                'class' => TipoAlerta::class,
                'choice_label' => 'nombre', // Muestra la propiedad "nombre" en el desplegable
                'label' => 'Tipo de Incidencia',
                'placeholder' => 'Selecciona un tipo de alerta...', // Opción vacía al inicio
                'attr' => ['class' => 'form-select'] // Clase CSS de Bootstrap
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Alerta::class,
        ]);
    }
}
