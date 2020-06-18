<?php declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Api\CreatePlayerRequest;
use App\Models\AutogroupsRules;
use App\Models\Players;
use DB;
use Throwable;

/**
 * Class CreatePlayerService
 *
 * @package App\Services
 */
class CreatePlayerService
{
    /**
     * @param CreatePlayerRequest $request
     * @return void
     *
     * @throws Throwable
     */
    public function create(CreatePlayerRequest $request): void
    {
        DB::beginTransaction();
        try {
            $player = Players::create(['display_name' => $request->display_name]);
            $this->setAutoName($request, $player);
            $this->setAutoGroup($player);
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    /**
     * @param CreatePlayerRequest $request
     * @param Players $player
     */
    private function setAutoName(CreatePlayerRequest $request, Players $player): void
    {
        if ($request->auto) {
            $player->update(['display_name' => $this->getAutoDisplayName($player)]);
        }
    }

    /**
     * @param Players $player
     */
    private function setAutoGroup(Players $player): void
    {
        $currentContextAutoGroups = AutogroupsRules::get()
            ->pluck('weight', 'group_id')
            ->toArray();
        if (!empty($currentContextAutoGroups)) {
            $player->update(['autogroup_id' => $this->getRandomWeightedElement($currentContextAutoGroups)]);
        }
    }

    /**
     * @see https://gist.github.com/irazasyed/f41f8688a2b3b8f7b6df
     *
     * @param array $weightedValues
     * @return int|null
     *
     * P.S. Sry <3
     */
    private function getRandomWeightedElement(array $weightedValues)
    {
        $rand = mt_rand(1, (int)array_sum($weightedValues));

        foreach ($weightedValues as $key => $value) {
            $rand -= $value;
            if ($rand <= 0) {
                return (int) $key;
            }
        }

        return null;
    }

    /**
     * @param Players $player
     * @return string
     */
    private function getAutoDisplayName(Players $player): string
    {
        return "Player #{$player->id}";
    }
}
