<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();

        $this->post('/authors', $this->data());

        $authors = Author::all();

        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
        $this->assertEquals('1997/28/09', $authors->first()->dob->format('Y/d/m'));
    }

    /** @test */
    public function an_author_name_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function an_author_dob_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));

        $response->assertSessionHasErrors('dob');
    }

    /** @test */
    public function the_same_author_name_cannot_be_stored_twice()
    {
        $this->post('/authors', $this->data());

        $response = $this->post('/authors', $this->data());

        $response->assertSessionHasErrors('name');
        $this->assertCount(1, Author::all());
    }




    private function data()
    {
        return [
            'name' => 'babul',
            'dob' => '09/28/1997'
        ];
    }
}
