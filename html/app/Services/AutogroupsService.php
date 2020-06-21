<?php declare(strict_types=1);

namespace App\Services;

use App\Models\AutogroupsRules;
use DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AutogroupsService
 *
 * @package App\Services
 */
class AutogroupsService
{
    /**
     * @param Collection $allGroups
     * @return array
     */
    public function getIndexData(Collection $allGroups): array
    {
        $autoGroups = AutogroupsRules::all();
        if ($allGroups->isNotEmpty()) {
            $autoGroups->each(function (AutogroupsRules $item) use ($allGroups) {
                $item->labelSecured = $allGroups->where('id', '=', $item->group_id)->first()->label ?? 'Undefined';
            });
        }

        $weightSum = 0;
        $totalRegistrationsSum = 0;
        $activeAutoGroupsIds = [];
        if ($autoGroups->isNotEmpty()) {
            $activeAutoGroupsIds = $autoGroups->pluck('group_id')->toArray();
            if ($autoGroups->where('weight', '>', 0)->count() > 0) {
                $weightSum = array_sum(array_column($autoGroups->toArray(), 'weight'));
                $playersData = DB::table('players')
                    ->select('autogroup_id', DB::raw('count(*) as registrations_count'))
                    ->where('created_at', '>=', $autoGroups->first()->created_at)
                    ->groupBy('autogroup_id')
                    ->get()
                    ->pluck('registrations_count', 'autogroup_id')
                    ->toArray();
                $totalRegistrationsSum = array_sum($playersData);
                $autoGroups->each(function (AutogroupsRules $item) use ($playersData, $weightSum, $totalRegistrationsSum) {
                    $item->totalRegistrationsCalculated = $playersData[$item->id] ?? 0;
                    $item->weightPercentageCalculated = $this->getAutogroupWeightPercentage($weightSum, $item);
                    $item->totalRegistrationsPercentageCalculated = $this->getTotalAutogroupRegistrationsPercentage(
                        $totalRegistrationsSum,
                        $item,
                        $playersData
                    );
                });
            }
        }

        return [$autoGroups, $activeAutoGroupsIds, $weightSum, $totalRegistrationsSum];
    }

    /**
     * @param int $weightSum
     * @param AutogroupsRules $autoGroupRule
     *
     * @return false|float|int
     */
    private function getAutogroupWeightPercentage(int $weightSum, AutogroupsRules $autoGroupRule)
    {
        $weightPercentage = 0;
        if ($weightSum > 0) {
            $weightPercentage = round((($autoGroupRule->weight / $weightSum ) * 100), 1);
        }
        return $weightPercentage;
    }

    /**
     * @param int $totalRegistrationsSum
     * @param AutogroupsRules $autoGroupRule
     * @param array $playersData
     *
     * @return false|float|int
     */
    private function getTotalAutogroupRegistrationsPercentage(
        int $totalRegistrationsSum,
        AutogroupsRules $autoGroupRule,
        array $playersData
    ) {
        $totalRegistrationsPercentage = 0;
        if ($totalRegistrationsSum > 0) {
            $autoGroupRegistrations = $playersData[$autoGroupRule->id] ?? 0;
            if ($autoGroupRegistrations > 0) {
                $totalRegistrationsPercentage = round((($playersData[$autoGroupRule->id] / $totalRegistrationsSum ) * 100), 1);
            }
        }
        return $totalRegistrationsPercentage;
    }
}
