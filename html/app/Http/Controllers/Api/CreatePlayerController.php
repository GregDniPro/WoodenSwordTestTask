<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreatePlayerRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class CreatePlayerController
 *
 * @package App\Http\Controllers\Api
 */
class CreatePlayerController extends Controller
{

    public function __invoke(CreatePlayerRequest $request): JsonResponse
    {
        if ($request->auto) {
            //TODO
        }
        //$request->displayName;

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Player was successfully created!',
        ], Response::HTTP_OK);
    }
}
