<?php

namespace Tests\Unit\Controller;

use Spatie\Permission\Middlewares\RoleMiddleware;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
  public function setUp(): void
  {
    parent::setUp(); // TODO: Change the autogenerated stub
  }

  /**
   *@test
   */
  public function ShowRecordsReturnDataInValidFormat()
  {
    $this->withoutMiddleware(RoleMiddleware::class);
    $response = $this->get('/admin/calendar/show-records');
    $response
      ->assertStatus(200)
      ->assertJsonStructure(
        [
          '*' => [
            'id',
            'title',
            'start',
            'status',
            'className',
          ]
        ],
      );
  }

  /**
   *@test
   */
  public function showRecordsWithStatusOneReturnDataInValidFormat()
  {
    $response = $this->get('/records');
    $response
      ->assertStatus(200)
      ->assertJsonStructure(
        [
          '*' => [
            'id',
            'title',
            'start',
            'status',
            'className',
          ]
        ],
      );
  }
}
