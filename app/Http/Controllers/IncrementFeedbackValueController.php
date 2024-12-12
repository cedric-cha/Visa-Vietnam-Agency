<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Eliseekn\LaravelApiResponse\MakeApiResponse;
use Illuminate\Http\JsonResponse;

class IncrementFeedbackValueController extends Controller
{
    use MakeApiResponse;

    public function __invoke(Feedback $feedback): JsonResponse
    {
        if (! $feedback->increment('count')) {
            return $this->errorResponse('Failed to submit your feedback. Please retry later');
        }

        return $this->successResponse('Thanks for letting us know how you found us');
    }
}
