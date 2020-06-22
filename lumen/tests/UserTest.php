<?php

// use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testCreate()
    {
        $this->disableExceptionHandling();

        $user = factory('App\User')->raw();
        $response = $this->json('POST', '/users', $user);
        $response->assertResponseStatus(201);

        $this->seeInDatabase('users', ['id' => $user['id']]);
    }

    public function testDelete()
    {
        $this->disableExceptionHandling();
        $users = factory('App\User')->create();

        $this->delete('/users/' . $users['id'], []);
        $this->seeStatusCode(204);
    }

    public function testListUrls()
    {
        $this->disableExceptionHandling();
        $url = factory('App\Url')->create();

        $this->get('/users/' . $url['user_id'] . '/stats');
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

}
