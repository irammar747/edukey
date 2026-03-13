<?php

namespace App\Tests\Controller;

use App\Entity\TipoAlerta;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class TipoAlertaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $tipoAlertumRepository;
    private string $path = '/tipo/alerta/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->tipoAlertumRepository = $this->manager->getRepository(TipoAlerta::class);

        foreach ($this->tipoAlertumRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TipoAlertum index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'tipo_alertum[nombre]' => 'Testing',
            'tipo_alertum[mensaje]' => 'Testing',
            'tipo_alertum[gravedad]' => 'Testing',
            'tipo_alertum[consecuencia]' => 'Testing',
        ]);

        self::assertResponseRedirects('/tipo/alerta');

        self::assertSame(1, $this->tipoAlertumRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new TipoAlerta();
        $fixture->setNombre('My Title');
        $fixture->setMensaje('My Title');
        $fixture->setGravedad('My Title');
        $fixture->setConsecuencia('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TipoAlertum');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new TipoAlerta();
        $fixture->setNombre('Value');
        $fixture->setMensaje('Value');
        $fixture->setGravedad('Value');
        $fixture->setConsecuencia('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'tipo_alertum[nombre]' => 'Something New',
            'tipo_alertum[mensaje]' => 'Something New',
            'tipo_alertum[gravedad]' => 'Something New',
            'tipo_alertum[consecuencia]' => 'Something New',
        ]);

        self::assertResponseRedirects('/tipo/alerta');

        $fixture = $this->tipoAlertumRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getMensaje());
        self::assertSame('Something New', $fixture[0]->getGravedad());
        self::assertSame('Something New', $fixture[0]->getConsecuencia());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new TipoAlerta();
        $fixture->setNombre('Value');
        $fixture->setMensaje('Value');
        $fixture->setGravedad('Value');
        $fixture->setConsecuencia('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/tipo/alerta');
        self::assertSame(0, $this->tipoAlertumRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
