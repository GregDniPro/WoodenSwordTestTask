<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreatePlayerRequest;
use App\Models\Groups;
use App\Models\Players;
use DB;
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
     * @return JsonResponse
     */
    public function __invoke(CreatePlayerRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $player = Players::create(['display_name' => $request->display_name]);
            if ((bool) $request->auto) {
                $player->update(['display_name' => $this->getAutoDisplayName($player)]);
            }
            //TODO auto-groups logic here
            $currentContextAutoGroups = Groups::where('weight', '!=', 0)
                ->get()
                ->pluck('weight', 'id')
                ->toArray();
            if (!empty($currentContextAutoGroups)) {
                $player->update(['group_id' => $this->getRandomWeightedElement($currentContextAutoGroups)]);
            }
            //TODO auto-groups logic here
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_I_AM_A_TEAPOT,
                'message' => 'Oops, something goes wrong!',
                'error' => (string) $e
            ], Response::HTTP_I_AM_A_TEAPOT);
        }
        DB::commit();

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Player was successfully created!',
        ], Response::HTTP_OK);
    }

    /**
     * TODO maybe i should move it to service
     *
     * @param array $weightedValues
     * @return int|string TODO
     */
    private function getRandomWeightedElement(array $weightedValues)
    {
        $rand = mt_rand(1, (int)array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return $key;
            }
        }

        return null;
    }

    /**
     * TODO maybe i should move it to service
     *
     * @param Players $player
     * @return string
     */
    private function getAutoDisplayName(Players $player): string
    {
        return "Player #{$player->id}";
    }
}
