<?php

declare(strict_types=1);

namespace Test\Functional;


class NotFoundTest extends WebTestCase
{
    public function testNotFound(): void
    {
        $response = $this->app()->handle(self::json('GET', '/not-found'));

        self::assertEquals(404, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);


        self::assertEquals(['message' => '404 Not Found'], $data);
    }
}