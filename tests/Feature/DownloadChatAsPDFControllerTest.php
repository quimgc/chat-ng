<?php

namespace Tests\Feature;

use App\Chat;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use View;

class DownloadChatAsPDFControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function can_download_chat_as_pdf()
    {

        $user = factory(User::class)->create();
        View::share('user', $user);

        $chat = Chat::forceCreate(['name' => 'Chat1' ]);

        //TODO -> Afegir missatges al xat.

        $response = $this->actingAs($user)->get('/chat/' .$chat->id.'/pdf');

        $response->assertSuccessful();

        //TODO comprovar que realment el pdf conté la info. (si és pot ?
    }
}
