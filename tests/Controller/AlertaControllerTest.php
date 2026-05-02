<?php

namespace App\Tests\Controller;

use App\Entity\Alerta;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AlertaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $alertumRepository;
    private string $path = '/alerta/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->alertumRepository = $this->manager->getRepository(Alerta::class);

        foreach ($this->alertumRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Alertum index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'alertum[fecha]' => 'Testing',
            'alertum[estado]' => 'Testing',
            'alertum[prestamo]' => 'Testing',
            'alertum[tipoAlerta]' => 'Testing',
        ]);

        self::assertResponseRedirects('/alerta');

        self::assertSame(1, $this->alertumRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Alerta();
        $fixture->setFecha('My Title');
        $fixture->setEstado('My Title');
        $fixture->setPrestamo('My Title');
        $fixture->setTipoAlerta('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Alertum');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Alerta();
        $fixture->setFecha('Value');
        $fixture->setEstado('Value');
        $fixture->setPrestamo('Value');
        $fixture->setTipoAlerta('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'alertum[fecha]' => 'Something New',
            'alertum[estado]' => 'Something New',
            'alertum[prestamo]' => 'Something New',
            'alertum[tipoAlerta]' => 'Something New',
        ]);

        self::assertResponseRedirects('/alerta');

        $fixture = $this->alertumRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFecha());
        self::assertSame('Something New', $fixture[0]->getEstado());
        self::assertSame('Something New', $fixture[0]->getPrestamo());
        self::assertSame('Something New', $fixture[0]->getTipoAlerta());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Alerta();
        $fixture->setFecha('Value');
        $fixture->setEstado('Value');
        $fixture->setPrestamo('Value');
        $fixture->setTipoAlerta('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/alerta');
        self::assertSame(0, $this->alertumRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
