<?php

namespace App\Tests;

use App\Repository\FlightRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TicketControllerTest extends WebTestCase
{
    private FlightRepository $flightRepository;
    private TicketRepository $ticketRepository;

    protected function setUp(): void
    {
        $container = self::getContainer();

        $this->flightRepository = $container->get(FlightRepository::class);
        $this->ticketRepository = $container->get(TicketRepository::class);

        self::ensureKernelShutdown();
    }

    public function testUnathorized(): void
    {
        $client = static::createClient();

        $flight = $this->flightRepository->find(1);

        $client->request('POST', '/tickets', [], [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer unknown',
            ],
            json_encode([
                'flightId' => $flight->getUuid(),
                'passport' => 'passportID123',
            ])
        );

        $json = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
        self::assertEquals('Unauthorized access!', $json['message']);
    }

    public function testUnknownFlight(): void
    {
        $client = static::createClient();

        $flightId = 9999999;

        $client->request('POST', '/tickets', [], [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer  s3cr3tV@lu3',
            ],
            json_encode([
                'flightId' => $flightId,
                'passport' => 'passportID123',
            ])
        );

        $json = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
        self::assertEquals(sprintf('Flight with ID: [%s] not found!', $flightId), $json['message']);
    }

    public function testSuccessCreate(): void
    {
        $client = static::createClient();

        $flight = $this->flightRepository->find(1);

        $client->request('POST', '/tickets', [], [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer s3cr3tV@lu3',
            ],
            json_encode([
                'flightId' => $flight->getUuid(),
                'passport' => 'passportID123',
            ])
        );

        $json = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertArrayHasKey('flightNumber', $json);
        self::assertIsString($json['flightNumber']);
        self::assertEquals(36, strlen($json['flightNumber']));
        self::assertArrayHasKey('departure', $json);
        self::assertIsString($json['departure']['date']);
        self::assertIsString($json['departure']['time']);
        self::assertArrayHasKey('airports', $json);
        self::assertArrayHasKey('source', $json['airports']);
        self::assertArrayHasKey('destinations', $json['airports']);
        self::assertArrayHasKey('aircraft', $json);
        self::assertIsString($json['aircraft']['manufacturer']);
        self::assertIsString($json['aircraft']['model']);
        self::assertArrayHasKey('ticketNumber', $json);
        self::assertIsString($json['ticketNumber']);
        self::assertArrayHasKey('passport', $json);
        self::assertIsString($json['passport']);
        self::assertArrayHasKey('seatNumber', $json);
        self::assertIsInt($json['seatNumber']);
    }
}
