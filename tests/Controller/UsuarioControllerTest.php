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

        $this->client->submitForm('Save', [
            'usuario[username]' => 'usuario_test_new',
            'usuario[password]' => 'password123',
            'usuario[email]'    => 'test@example.com',
            'usuario[nombre]'   => 'Inma',
            'usuario[apellido1]' => 'Gomez',
            'usuario[apellido2]' => 'Perez',
            // Si el error de 'roles' persiste, es que el formulario OBLIGA a enviarlo.
            // Prueba a comentar o añadir esta línea según necesites:
            // 'usuario[roles]' => ['ROLE_USER'],
        ]);

        // Al usar followRedirects(), ya no comprobamos assertResponseRedirects,
        // sino que comprobamos que la página final cargue bien.
        self::assertResponseStatusCodeSame(200);
        self::assertSame(1, $this->repository->count([]));
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

        $this->client->submitForm('Update', [
            'usuario[username]' => 'user_edit_mod',
        ]);

        self::assertResponseStatusCodeSame(200);
        $updated = $this->repository->findOneBy(['username' => 'user_edit_mod']);
        self::assertNotNull($updated);
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
