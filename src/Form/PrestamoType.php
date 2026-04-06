<?php

namespace App\Form;

use App\Entity\Llave;
use App\Entity\Prestamo;
use App\Entity\Usuario;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrestamoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // 1. Obtenemos los datos que se le pasan al formulario (el objeto Prestamo)
        $prestamo = $options['data'] ?? null;

        $builder
            // Configuración para el campo Llave
            ->add('llave', EntityType::class, [
                'class' => Llave::class,
                'choice_label' => 'codigo', // <--- CAMBIO CLAVE: Usa la propiedad 'codigo' de la entidad Llave
                'label' => 'Llave asignada',
                'attr' => ['class' => 'ts-control'], // Para que mantenga el estilo de TomSelect
                'placeholder' => 'Seleccione una llave...',

                // Filtramos para que solo aparezcan las llaves disponibles
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->where('l.disponible = :val')
                        ->setParameter('val', true)
                        ->orderBy('l.codigo', 'ASC');
                },
            ])
            ->add('docente', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'username', // <--- CAMBIO CLAVE: Usa la propiedad 'username' de la entidad Usuario
                'label' => 'Docente / Solicitante',
                'attr' => ['class' => 'ts-control'], // Para que mantenga el estilo de TomSelect
                'placeholder' => 'Buscar docente...',
            ])
            ->add('f_prest', null, [
                'label' => 'Fecha de Préstamo',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])

            ->add('tiempo_lim', null, [
                'label' => 'Tiempo Límite',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('observaciones', TextareaType::class, [
                'label' => 'Observaciones',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 3,
                    'placeholder' => 'Notas adicionales sobre el estado de la llave...'
                ]
            ])

            ->add('personal', EntityType::class, [
                'class' => Usuario::class,
                'choice_label' => 'username', // Mostrar el nombre del personal, no el ID
                'label' => 'Atendido por',
                'disabled' => true,
                'attr' => ['class' => 'form-control']
            ])

        ;

        if ($prestamo && $prestamo->getLlave() !== null) {
            $builder->get('llave')->setDisabled(true);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestamo::class,
        ]);
    }
}
