<?php


namespace Tests\Feature;


use Tests\TestCase;

class ApartmentsApiTest extends TestCase
{
    /**
     * @test
     */
    public function allApartments() : void
    {
        $response = $this->get('/api/apartments');

        $response
            ->assertStatus(200)
            ->assertJsonCount(9);
    }

    /**
     * @dataProvider dataForFilterTest
     * @test
     */
    public function bathroomFilterTest($data, $expected) : void
    {
        $response = $this->get($data['url']);

        $response
            ->assertStatus(200)
            ->assertJsonCount($expected['count']);
    }

    /**
     * @test
     */
    public function wrongParamsTest() : void
    {
        $response = $this->get('/api/apartments?filter[bathrooms]=sdfsdf');

        $response
            ->assertStatus(400);
    }

    public function dataForFilterTest() : array
    {
        return [
            'test bathrooms' => [
                'data' => [
                    'url' => '/api/apartments?filter[bathrooms]=2'
                ],
                'expected' => [
                    'count' => 6
                ]
            ],
            'test bathrooms & bedrooms' => [
                'data' => [
                    'url' => '/api/apartments?filter[bathrooms]=2&filter[bedrooms]=5'
                ],
                'expected' => [
                    'count' => 1
                ]
            ],
            'test bedrooms & garages' => [
                'data' => [
                    'url' => '/api/apartments?filter[garages]=2&filter[bedrooms]=4'
                ],
                'expected' => [
                    'count' => 5
                ]
            ],
            'test name' => [
                'data' => [
                    'url' => '/api/apartments?filter[name]=Xavi'
                ],
                'expected' => [
                    'count' => 1
                ]
            ],
            'test price' => [
                'data' => [
                    'url' => '/api/apartments?filter[price]=300000-400000'
                ],
                'expected' => [
                    'count' => 4
                ]
            ],
            'test price_from' => [
                'data' => [
                    'url' => '/api/apartments?filter[price]=500000'
                ],
                'expected' => [
                    'count' => 3
                ]
            ],
        ];
    }
}
