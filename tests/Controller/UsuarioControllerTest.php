<?php

namespace App\Tests\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UsuarioControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/usuario/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        // Forzamos al cliente a seguir redirecciones automáticamente para evitar el error 301/303
        $this->client->followRedirects();

        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Usuario::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->request('GET', $this->path);
        self::assertResponseStatusCodeSame(200);
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));
        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('btn-guardar', [
            'usuario[username]' => 'usuario_test_new',
            'usuario[password]' => 'password123',
            'usuario[email]'    => 'test@example.com',
            'usuario[nombre]'   => 'Inmaculada',
            'usuario[apellido1]' => 'Gomez',
            'usuario[apellido2]' => 'Perez',
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertSame(1, $this->repository->count([]));
    }

    /**
     * PRUEBA DE INTEGRACIÓN: Validación de Tipos y Restricciones (ENTRADAS INVÁLIDAS)
     * Controla que los datos cumplan con las normas de definición.
     */
    public function testNewValidationErrors(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));
        self::assertResponseStatusCodeSame(200);

        echo $this->client->getResponse()->getContent();

        // Enviamos el formulario con datos inválidos a propósito
        $this->client->submitForm('btn-guardar', [
            'usuario[username]'  => '',                  // ERROR: No puede estar vacío
            'usuario[email]'     => 'correo-incorrecto', // ERROR: No es un email válido
            'usuario[nombre]'    => 'A',                 // ERROR: Demasiado corto (longitud mínima)
            'usuario[apellido1]' => 'Gomez',
            'usuario[apellido2]' => 'Perez',
        ]);

        self::assertResponseStatusCodeSame(200);

        // Comprobamos que NO se ha guardado nada en la base de datos
        self::assertSame(0, $this->repository->count([]));

        // Comprobamos que el HTML devuelto contiene algún mensaje de error de validación típico
        self::assertStringContainsString('This value should not be blank', $this->client->getResponse()->getContent());
    }

    public function testEdit(): void
    {
        $fixture = new Usuario();
        $fixture->setUsername('user_edit');
        $fixture->setPassword('123');
        $fixture->setEmail('edit@test.com');
        $fixture->setNombre('Nombre');
        $fixture->setApellido1('Apellido');
        $fixture->setApellido2('Apellido2');
        $fixture->setRoles(['ROLE_USER']);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('btn-guardar', [
            'usuario[username]' => 'user_edit_mod',
        ]);

        self::assertResponseStatusCodeSame(200);
        $updated = $this->repository->findOneBy(['username' => 'user_edit_mod']);
        self::assertNotNull($updated);
    }

    /**
     * PRUEBA DE INTEGRACIÓN: Modificación con datos inválidos
     */
    public function testEditValidationErrors(): void
    {
        $fixture = new Usuario();
        $fixture->setUsername('original_user');
        $fixture->setPassword('123');
        $fixture->setEmail('original@test.com');
        $fixture->setNombre('Nombre');
        $fixture->setApellido1('Apellido');
        $fixture->setApellido2('Apellido2');
        $fixture->setRoles(['ROLE_USER']);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        // Intentamos modificar el usuario con un email inválido
        $this->client->submitForm('btn-guardar', [
            'usuario[email]' => 'esto_no_es_un_email',
        ]);

        self::assertResponseStatusCodeSame(200);

        // Verificamos que el email en la base de datos NO se actualizó y mantiene el original
        $notUpdated = $this->repository->findOneBy(['username' => 'original_user']);
        self::assertEquals('original@test.com', $notUpdated->getEmail());
    }

    public function testRemove(): void
    {
        $fixture = new Usuario();
        $fixture->setUsername('delete_me');
        $fixture->setPassword('123');
        $fixture->setEmail('del@test.com');
        $fixture->setNombre('Borrar');
        $fixture->setApellido1('Borrar');
        $fixture->setApellido2('Apellido2');
        $fixture->setRoles(['ROLE_USER']);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseStatusCodeSame(200);
        self::assertSame(0, $this->repository->count([]));
    }
}
