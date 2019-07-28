<?php

namespace Specialtactics\L5Api\Tests\Api\Patch;

use Specialtactics\L5Api\Tests\TestCase;

class PatchTest extends TestCase
{
    /**
     * @testdox Updating a forum description
     * @test
     */
    public function patchForumDescription()
    {
        $description = 'Lorum Ipsum new discussions';
        $differentDescription = 'Definitely not a new forum';

        // First create a forum
        $jsonResponse = $this->actingAsAdmin()
            ->json('POST', '/forums', [
                'name' => 'New Forum',
                'description' => $description,
            ]);

        $forumId = $jsonResponse->decodeResponseJson('data.id');

        // Do the patch test
        $jsonResponse = $this->actingAsAdmin()
            ->json('PATCH', '/forums/' . $forumId, [
                'description' => $differentDescription,
            ]);

        $jsonResponse->assertStatus(200);

        $forum = $jsonResponse->decodeResponseJson();

        $this->assertEquals($differentDescription, $forum['data']['description']);
    }
}