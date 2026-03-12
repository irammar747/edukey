<?php

namespace App\Tests\Controller;

use App\Entity\Recurso;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class RecursoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $recursoRepository;
    private string $path = '/recurso/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->recursoRepository = $this->manager->getRepository(Recurso::class);

        foreach ($this->recursoRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Recurso index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'recurso[nombre]' => 'Testing',
            'recurso[descripcion]' => 'Testing',
            'recurso[tipo]' => 'Testing',
            'recurso[deleted_at]' => 'Testing',
            'recurso[llaves]' => 'Testing',
        ]);

        self::assertResponseRedirects('/recurso');

        self::assertSame(1, $this->recursoRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Recurso();
        $fixture->setNombre('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setTipo('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setLlaves('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Recurso');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Recurso();
        $fixture->setNombre('Value');
        $fixture->setDescripcion('Value');
        $fixture->setTipo('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setLlaves('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'recurso[nombre]' => 'Something New',
            'recurso[descripcion]' => 'Something New',
            'recurso[tipo]' => 'Something New',
            'recurso[deleted_at]' => 'Something New',
            'recurso[llaves]' => 'Something New',
        ]);

        self::assertResponseRedirects('/recurso');

        $fixture = $this->recursoRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getDescripcion());
        self::assertSame('Something New', $fixture[0]->getTipo());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getLlaves());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Recurso();
        $fixture->setNombre('Value');
        $fixture->setDescripcion('Value');
        $fixture->setTipo('Value');
        $fixture->setDeletedAt('Value');
        $fixture->setLlaves('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/recurso');
        self::assertSame(0, $this->recursoRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
