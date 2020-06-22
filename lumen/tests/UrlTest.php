<?php

// use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UrlTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $this->disableExceptionHandling();

        $url = factory('App\Url')->create();
        $response = $this->json('POST', '/users/' . $url['user_id'] . '/urls', $url->toArray());
        $response->assertResponseStatus(201);

        $this->seeInDatabase('urls', ['id' => $url->id]);
    }

    public function testDelete()
    {
        $this->disableExceptionHandling();
        $users = factory('App\Url')->create();

        $this->delete('/urls/' . $users['id'], []);
        $this->seeStatusCode(204);
    }

    public function testListUrls()
    {
        $this->disableExceptionHandling();
        $urls = factory('App\Url')->create();

        $this->get('/urls/stats');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'hits',
            'urlCount',
            'topUrls' => [
                [
                    'id',
                    'url',
                    'short_url',
                    'hits'
                ]
            ],
        ]);
    }

    public function testShowUrl()
    {
        $this->disableExceptionHandling();
        $url = factory('App\Url')->create();

        $this->get('/urls/stats/' . $url->id);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'id',
            'url',
            'short_url',
            'hits'
        ]);
    }

}
