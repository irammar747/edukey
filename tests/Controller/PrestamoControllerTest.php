<?php

namespace App\Tests\Controller;

use App\Entity\Prestamo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PrestamoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $prestamoRepository;
    private string $path = '/prestamo/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->prestamoRepository = $this->manager->getRepository(Prestamo::class);

        foreach ($this->prestamoRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Prestamo index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'prestamo[f_prest]' => 'Testing',
            'prestamo[f_devo]' => 'Testing',
            'prestamo[tiempo_lim]' => 'Testing',
            'prestamo[observaciones]' => 'Testing',
            'prestamo[llave]' => 'Testing',
            'prestamo[docente]' => 'Testing',
            'prestamo[personal]' => 'Testing',
        ]);

        self::assertResponseRedirects('/prestamo');

        self::assertSame(1, $this->prestamoRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Prestamo();
        $fixture->setFPrest('My Title');
        $fixture->setFDevo('My Title');
        $fixture->setTiempoLim('My Title');
        $fixture->setObservaciones('My Title');
        $fixture->setLlave('My Title');
        $fixture->setDocente('My Title');
        $fixture->setPersonal('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Prestamo');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Prestamo();
        $fixture->setFPrest('Value');
        $fixture->setFDevo('Value');
        $fixture->setTiempoLim('Value');
        $fixture->setObservaciones('Value');
        $fixture->setLlave('Value');
        $fixture->setDocente('Value');
        $fixture->setPersonal('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'prestamo[f_prest]' => 'Something New',
            'prestamo[f_devo]' => 'Something New',
            'prestamo[tiempo_lim]' => 'Something New',
            'prestamo[observaciones]' => 'Something New',
            'prestamo[llave]' => 'Something New',
            'prestamo[docente]' => 'Something New',
            'prestamo[personal]' => 'Something New',
        ]);

        self::assertResponseRedirects('/prestamo');

        $fixture = $this->prestamoRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFPrest());
        self::assertSame('Something New', $fixture[0]->getFDevo());
        self::assertSame('Something New', $fixture[0]->getTiempoLim());
        self::assertSame('Something New', $fixture[0]->getObservaciones());
        self::assertSame('Something New', $fixture[0]->getLlave());
        self::assertSame('Something New', $fixture[0]->getDocente());
        self::assertSame('Something New', $fixture[0]->getPersonal());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Prestamo();
        $fixture->setFPrest('Value');
        $fixture->setFDevo('Value');
        $fixture->setTiempoLim('Value');
        $fixture->setObservaciones('Value');
        $fixture->setLlave('Value');
        $fixture->setDocente('Value');
        $fixture->setPersonal('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/prestamo');
        self::assertSame(0, $this->prestamoRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
