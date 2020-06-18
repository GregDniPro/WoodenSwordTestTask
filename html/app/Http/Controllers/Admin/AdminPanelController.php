<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SetAutoGroupsRequest;
use App\Http\Requests\Admin\UpdateAutoGroupsRequest;
use App\Models\AutogroupsRules;
use App\Models\Groups;
use App\Models\Players;
use DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
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
        $allGroups = Groups::all();
        $autoGroups = AutogroupsRules::all()->each(function (AutogroupsRules $item) use ($allGroups) {
            $item->labelSecured = $allGroups->where('id', '=', $item->group_id)->first()->label;
        });

        $playersCount = 0;
        if ($autoGroups->isNotEmpty()) {
            $autoGroupsWereCreatedAt = $autoGroups->first()->created_at;
            $playersCount = Players::where('created_at', '>=', $autoGroupsWereCreatedAt)->count('id');
        }

        return view('admin.autogroups.index', [
            'autoGroups' => $autoGroups,
            'allGroups' => $allGroups,
            'playersCount' => $playersCount,
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
                'message' => (string) $e,
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
                'message' => (string) $e,
            ], Response::HTTP_I_AM_A_TEAPOT);
        }
        DB::commit();

        Session::flash('message', 'Autogroups were updated successfully!');
        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'Autogroups were updated successfully!',
        ], Response::HTTP_OK);
    }
}
