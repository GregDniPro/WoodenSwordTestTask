<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SetAutoGroupsRequest;
use App\Http\Requests\Admin\UpdateAutoGroupsRequest;
use App\Models\AutogroupsRules;
use App\Models\Groups;
use App\Services\AutogroupsService;
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
    public function index(AutogroupsService $autogroupsService)
    {
        $allGroups = Groups::all();
        list($autoGroups, $activeAutoGroupsIds, $weightSum, $totalRegistrationsSum) = $autogroupsService
            ->getIndexData($allGroups);

        return view('admin.autogroups.index', [
            'allGroups' => $allGroups,
            'autoGroups' => $autoGroups,
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
