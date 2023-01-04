<?php

namespace Tests\Feature\app\Http\Controller\Admin;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * ListActivitiesControllerTest
 * @package Tests\Unit\app\Http\Controllers\Admin
 * @author Juan Camilo Rosillo Martinez <juanca1158@hotmail.com>
 */
class ListActivitiesControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }


    /**
     * Test list activities for table
     *
     * @return void
     */
    public function testListActivities(): void
    {
        $date = Carbon::now()->format('Y-m-d');
        $numberPeople = 5;

        $activities = Activity::factory(3)->create([
            'init_date' => $date . ' 00:00:00',
            'end_date' => $date . ' 23:59:59',
            'popularity' => 5,
        ])->toArray();

        $expected = [
            "current_page" => 1,
            "data" => $activities,
            "first_page_url" => "http://localhost/activities/filter?page=1",
            "from" => 1,
            "last_page" => 1,
            "last_page_url" => "http://localhost/activities/filter?page=1",
            "links" => [
                [
                    "url" => null,
                    "label" => __('pagination.previous'),
                    "active" => false,
                ],
                [
                    "url" => "http://localhost/activities/filter?page=1",
                    "label" => "1",
                    "active" => true,
                ],
                [
                    "url" => null,
                    "label" => __('pagination.next'),
                    "active" => false,
                ],
            ],
            "next_page_url" => null,
            "path" => "http://localhost/activities/filter",
            "per_page" => 10,
            "prev_page_url" => null,
            "to" => 3,
            "total" => 3
        ];

        $response = $this->postJson(route('activities.filter'), [
            'date' => $date,
            'number_people' => $numberPeople,
        ]);

        $response->assertJson($expected);
    }
}
