<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    // src/Form/UserProfileType.php

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', null, ['label' => 'Nombre'])
            ->add('apellido1', null, ['label' => 'Primer Apellido'])
            ->add('apellido2', null, ['label' => 'Segundo Apellido'])
            ->add('email', EmailType::class, [
                'label' => 'Correo Electrónico',
                'attr' => [
                    'placeholder' => 'ejemplo@edukey.com',
                    'class' => 'form-control'
                ]
            ])
            ->add('telefono', TelType::class, [
                'label' => 'Teléfono',
                'required' => false,
                'attr' => [
                    'pattern' => '[0-9]{9}', // Solo permite 9 números
                    'title' => 'Introduce un número de teléfono válido (9 dígitos)',
                    'class' => 'form-control',
                    'inputmode' => 'numeric' // Fuerza el teclado numérico en móviles
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
