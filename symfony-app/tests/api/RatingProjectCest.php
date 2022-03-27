<?php

namespace App\Tests\Api;

use App\Entity\Project;
use \App\Tests\ApiTester;
use Symfony\Component\HttpFoundation\Response;

class RatingProjectCest
{
    private ?string $username = null;
    private ?int $projectId = null;

    public function _before(ApiTester $I)
    {

        $this->projectId = $I->grabFromRepository(Project::class,'id');

        if(!$this->projectId)
        {
            $I->expectTo('find project check database and load fixture');
            return false;
        }
        $I->amGoingTo('rate project/update rating');
        $I->haveHttpHeader('Content-Type', 'application/json');

        $string = base64_encode(random_bytes(10));
        $this->username = $string.'@gmail.com';

        $I->sendPost('/register/client', [
            'lastname' => 'test_name',
            'firstname' => 'first_name',
            'password' => '1234567',
            'username' => $this->username
        ]);

        $I->seeResponseCodeIs(Response::HTTP_OK);

    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->sendPost('/api/login_check', [
            'password' => '1234567',
            'username' => $this->username
        ]);

        $I->seeResponseCodeIs(Response::HTTP_OK);

        $response = $I->grabResponse();

        $token = json_decode($response,true);

        $I->amGoingTo('check add rating without token ');

        $I->sendPost('/api/rating/save', [
            'project_id' => 1,
            'ratingData' => [
                'overall_satisfaction' => 1,
                'communication' => 1,
                'quality_of_work' => 1,
                'value_for_money' => 1,
                'review_text' => 'test_review_test',
            ]
        ]);

        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);

        $I->amGoingTo('check add rating with wrong  token ');

        $I->amBearerAuthenticated('fefefefefe');

        $I->sendPost('/api/rating/save', [
            'project_id' => 1,
            'ratingData' => [
                'overall_satisfaction' => 1,
                'communication' => 1,
                'quality_of_work' => 1,
                'value_for_money' => 1,
                'review_text' => 'test_review_test',
            ]
        ]);

        $I->seeResponseCodeIs(Response::HTTP_FORBIDDEN);

        $I->amBearerAuthenticated($token['token']);

        $I->sendPost('/api/rating/save', [
            'project_id' => 1,
            'ratingData' => [
                'overall_satisfaction' => 1,
                'communication' => 1,
                'quality_of_work' => 1,
                'value_for_money' => 1,
                'review_text' => 'test_review_test',
            ]
        ]);
    }
}
