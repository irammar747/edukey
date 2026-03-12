<?php

namespace App\Form;

use App\Entity\Departamento;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', null, ['label' => 'Usuario'])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Usuario' => 'ROLE_USER',
                    'Administrador' => 'ROLE_ADMIN',
                    'Personal' => 'ROLE_PERSONAL',
                ],
                'multiple' => true, // OBLIGATORIO para que sea un array
                'expanded' => true,
            ])
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
            ])
            ->add('departamento', EntityType::class, [
                'class' => Departamento::class,
                'choice_label' => 'nombre', // Muestra el nombre del departamento
                'placeholder' => 'Selecciona un departamento...',
                'required' => false,
                'attr' => ['class' => 'form-select'] // Estilo de Bootstrap
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
