@extends('admin.layout')

@php
    /** @var Illuminate\Database\Eloquent\Collection $autoGroups */
    /** @var Illuminate\Database\Eloquent\Collection $allGroups */
    /** @var array $playersData */
    /** @var array $activeAutoGroupsIds */
    /** @var int $weightSum */
    /** @var int $totalRegistrationsSum */
@endphp

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/chosen/chosen.css') }}">
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 text-left">
                <button type="button" class="btn btn-info show-all-groups-btn">Show all groups</button>
            </div>
            <div class="col-lg-9">
                <select data-placeholder="Auto groups selection:" class="chosen chosen-autogroups-input" multiple="true" style="width:400px;">
                    @foreach($allGroups as $group)
                        <option value="{{ $group->id }}" @if(in_array($group->id, $activeAutoGroupsIds)) selected="selected" @endif>
                            {{ $group->label }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-success set-autogroups-selection-btn">Set autogroups</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1>Autogroups</h1>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Label</th>
                        <th scope="col">Weight</th>
                        <th scope="col">Weight %</th>
                        <th scope="col">Registrations</th>
                        <th scope="col">Registrations %</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($autoGroups->isEmpty())
                            <tr class="text-center">
                                <td></td>
                                <td></td>
                                <td><p class="text text-warning">Please set autogroups first!</p></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @else
                            @foreach ($autoGroups as $autoGroup)
                                @php
                                    //TODO move this script from view! (maybe to some TmpEloquentModel or something like that
                                    $weightPercentage = 0;
                                    if ($weightSum > 0) {
                                        $weightPercentage = round((($autoGroup->weight / $weightSum ) * 100), 1);
                                    }
                                    $totalRegistrationsPercentage = 0;
                                    if ($totalRegistrationsSum > 0) {
                                        $autoGroupRegistrations = $playersData[$autoGroup->id] ?? 0;
                                        if ($autoGroupRegistrations > 0) {
                                            $totalRegistrationsPercentage = round((($playersData[$autoGroup->id] / $totalRegistrationsSum ) * 100), 1);
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $autoGroup->labelSecured }}</td>
                                    <td>
                                        <input class="form-control auto-group-data-input" data-groupId="{{ $autoGroup->group_id }}" type="number" value="{{ $autoGroup->weight }}" min="1"/>
                                    </td>
                                    <td>{{ $weightPercentage }} %</td>
                                    <td>{{ $playersData[$autoGroup->id] ?? 0}}</td>
                                    <td>{{ $totalRegistrationsPercentage }} %</td>
                                </tr>
                            @endforeach

                            <tr class="bg-dark">
                                <td>Total weight</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $weightSum }}</td>
                            </tr>
                            <tr class="bg-dark">
                                <td>Total registrations</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $totalRegistrationsSum }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-right">
                <button type="button" class="btn btn-info update-autogroups-data-btn">Update (will reset current registration context)</button>
                <br><br>
                @if($autoGroups->isNotEmpty())
                    <form method="post" action="/adminpanel/reset-autogroups">
                        @csrf
                        <button type="submit" class="btn btn-danger all-data-reset-btn" style="float: right">RESET</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="row all-groups-block" style="display: none">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1>All Groups</h1>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Label</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($allGroups->isEmpty())
                        <tr class="text-center">
                            <td></td>
                            <td><p class="text text-warning">Please create groups manually or run seeder first!</p></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @else
                        @foreach ($allGroups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td @if(in_array($group->id, $activeAutoGroupsIds)) class="bg-success" @endif>{{ $group->label }}</td>
                                <td>{{ $group->created_at }}</td>
                                <td>{{ $group->updated_at }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/chosen/chosen.jquery.js') }}"></script>
    <script type="application/javascript" src="{{ asset('assets/js/admin/autogroups/index.js') }}"></script>
@endsection
