<?php

namespace App\Tests\Controller;

use App\Entity\Llave;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LlaveControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $llaveRepository;
    private string $path = '/llave/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->llaveRepository = $this->manager->getRepository(Llave::class);

        foreach ($this->llaveRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Llave index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'llave[codigo]' => 'Testing',
            'llave[descripcion]' => 'Testing',
            'llave[ubicacion]' => 'Testing',
            'llave[disponible]' => 1//,
            //'llave[deleted_at]' => '',
            //'llave[recursos]' => 'Testing',
        ]);

        self::assertResponseRedirects('/llave');

        self::assertSame(1, $this->llaveRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Llave();
        $fixture->setCodigo('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setUbicacion('My Title');
        $fixture->setDisponible(true);
        //$fixture->setDeletedAt('');
        //$fixture->setRecursos('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Llave');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Llave();
        $fixture->setCodigo('Value');
        $fixture->setDescripcion('Value');
        $fixture->setUbicacion('Value');
        $fixture->setDisponible(1);
        //$fixture->setDeletedAt('');
        //$fixture->setRecursos('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'llave[codigo]' => 'Something New',
            'llave[descripcion]' => 'Something New',
            'llave[ubicacion]' => 'Something New',
            'llave[disponible]' => true//,
            //'llave[deleted_at]' => '',
            //'llave[recursos]' => 'Something New',
        ]);

        self::assertResponseRedirects('/llave');

        $fixture = $this->llaveRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getCodigo());
        self::assertSame('Something New', $fixture[0]->getDescripcion());
        self::assertSame('Something New', $fixture[0]->getUbicacion());
        self::assertSame(true, $fixture[0]->isDisponible());
        //self::assertSame('Something New', $fixture[0]->getDeletedAt());
        //self::assertSame('Something New', $fixture[0]->getRecursos());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Llave();
        $fixture->setCodigo('Value');
        $fixture->setDescripcion('Value');
        $fixture->setUbicacion('Value');
        $fixture->setDisponible(1);
        //$fixture->setDeletedAt('');
        //$fixture->setRecursos('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/llave');
        self::assertSame(0, $this->llaveRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
