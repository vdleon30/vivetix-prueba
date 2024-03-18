<?php

namespace Tests\Feature\App\Requests;

use Illuminate\Support\MessageBag;
use Tests\TestCase;
use App\Http\Requests\FormRequestCustom;

class FormRequestCustomTest extends TestCase
{
    /**
     * Test failedValidation method.
     *
     * @return void
     */
    public function testFailedValidation()
    {
        $request = new FormRequestCustom();

        $validator = \Mockery::mock(\Illuminate\Contracts\Validation\Validator::class);
        $validator->shouldReceive('errors')->andReturn(new MessageBag(['field_name' => ['Error message']]));
        $validator->shouldReceive('getMessageBag')->andReturn(new MessageBag(['field_name' => ['Error message']]));

        $response = $request->failedValidation($validator);

        $this->assertNotNull($response);
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode()); // Verifica el código de estado de redirección
    }
}
