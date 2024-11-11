<?php

namespace Tests\Feature;

use App\Models\Applicant;
use App\Models\Order;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ApplicantTest extends TestCase
{
    public function test_can_store_applicant(): void
    {
        $applicant = Applicant::factory()
            ->for(Order::factory()->create())
            ->make([
                'photo' => UploadedFile::fake()->image('photo.jpg'),
                'passport_image' => UploadedFile::fake()->image('passport_image.jpg'),
            ]);

        $this
            ->post('/api/applicants', $applicant->getAttributes())
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json
                ->where('status', 'success')
                ->where('message', 'Applicant created')
                ->etc()
            );
    }
}
