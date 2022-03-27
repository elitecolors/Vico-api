<?php

namespace App\Tests\Api;

use \App\Tests\ApiTester;
use Symfony\Component\HttpFoundation\Response;

class CreateClientCest
{
    private ?string $username = null;
    public function _before(ApiTester $I)
    {
        $I->amGoingTo('create a new client');
        $I->haveHttpHeader('Content-Type', 'application/json');

        $string = base64_encode(random_bytes(10));
        $this->username = $string.'@gmail.com';
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->amGoingTo('test without body content');

        $I->sendPost('/register/client',[]);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);

        $I->amGoingTo('check with wrong data/validator');
        $I->sendPost('/register/client', [
            'lastname' => 'test_name',
            'firstname' => 'first_name',
            'password' => '1234',
            'username' => $this->username
        ]);

        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);


        $I->sendPost('/register/client', [
            'lastname' => 'test_name',
            'firstname' => 'first_name',
            'password' => '1234567',
            'username' => $this->username
        ]);

        $I->seeResponseCodeIs(Response::HTTP_OK);

        $I->amGoingTo('get token ');

        $I->sendPost('/api/login_check', [
            'password' => '1234567',
            'username' => $this->username
        ]);

        $I->seeResponseCodeIs(Response::HTTP_OK);

        $I->seeResponseContains('token');

    }
}
