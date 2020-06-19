<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SetAutoGroupsRequest;
use App\Http\Requests\Admin\UpdateAutoGroupsRequest;
use App\Models\AutogroupsRules;
use App\Models\Groups;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Session;
use Throwable;

/**
 * Class CreatePlayerController
 *
 * @package App\Http\Controllers\Api
 */
class AdminPanelController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        //TODO possibly should move it to some separate Component/Service or... need advice xD
        $allGroups = Groups::all();
        $autoGroups = AutogroupsRules::all();
        if ($allGroups->isNotEmpty()) {
            $autoGroups->each(function (AutogroupsRules $item) use ($allGroups) {
                $item->labelSecured = $allGroups->where('id', '=', $item->group_id)->first()->label ?? 'Undefined';
            });
        }

        $playersData = [];
        $activeAutoGroupsIds = [];
        $weightSum = 0;
        $totalRegistrationsSum = 0;
        $activeAutoGroupsIds = $autoGroups->pluck('group_id')->toArray();

        if ($autoGroups->isNotEmpty() && ($autoGroups->where('weight', '>', 0)->count() > 0)) {
            $weightSum = array_sum(array_column($autoGroups->toArray(), 'weight'));
            $playersData = DB::table('players')
                ->select('autogroup_id', DB::raw('count(*) as registrations_count'))
                ->where('created_at', '>=', $autoGroups->first()->created_at)
                ->groupBy('autogroup_id')
                ->get()
                ->pluck('registrations_count', 'autogroup_id')
                ->toArray();
            $totalRegistrationsSum = array_sum($playersData);
        }

        return view('admin.autogroups.index', [
            'autoGroups' => $autoGroups,
            'allGroups' => $allGroups,
            'playersData' => $playersData,
            'activeAutoGroupsIds' => $activeAutoGroupsIds,
            'weightSum' => $weightSum,
            'totalRegistrationsSum' => $totalRegistrationsSum,
        ]);
    }

    /**
     * @param SetAutoGroupsRequest $request
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function setAutoGroups(SetAutoGroupsRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            AutogroupsRules::truncate();
            AutogroupsRules::insert($request->groups_data);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_I_AM_A_TEAPOT,
                'message' => (string)$e,
            ], Response::HTTP_I_AM_A_TEAPOT);
        }
        DB::commit();

        Session::flash('message', 'Autogroups were created successfully!');
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Autogroups were created successfully!',
        ], Response::HTTP_OK);
    }

    /**
     * @param UpdateAutoGroupsRequest $request
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function updateAutoGroups(UpdateAutoGroupsRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            AutogroupsRules::truncate();
            AutogroupsRules::insert($request->autogroups_data);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => Response::HTTP_I_AM_A_TEAPOT,
                'message' => (string)$e,
            ], Response::HTTP_I_AM_A_TEAPOT);
        }
        DB::commit();

        Session::flash('message', 'Autogroups were updated successfully!');
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Autogroups were updated successfully!',
        ], Response::HTTP_OK);
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function resetAutoGroups()
    {
        AutogroupsRules::truncate();
        return redirect('/adminpanel/groups');
    }
}
