<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreatePlayerRequest;
use App\Services\CreatePlayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

/**
 * Class CreatePlayerController
 *
 * @package App\Http\Controllers\Api
 */
class CreatePlayerController extends Controller
{
    /**
     * @param CreatePlayerRequest $request
     *
     * @param CreatePlayerService $createPlayerService
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function __invoke(CreatePlayerRequest $request, CreatePlayerService $createPlayerService): JsonResponse
    {
        try {
            $createPlayerService->create($request);
        } catch (Throwable $e) {
            return response()->json([
                'status' => Response::HTTP_I_AM_A_TEAPOT,
                'message' => 'Oops, something goes wrong!',
                'error' => (string) $e
            ], Response::HTTP_I_AM_A_TEAPOT);
        }

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Player was successfully created!',
        ], Response::HTTP_OK);
    }


}
