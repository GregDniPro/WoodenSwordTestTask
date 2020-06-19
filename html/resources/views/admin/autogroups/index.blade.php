@extends('admin.layout')

@php
    /** @var Illuminate\Database\Eloquent\Collection $autoGroups */
    /** @var Illuminate\Database\Eloquent\Collection $allGroups */
    /** @var int $playersCount */
    $activeAutoGroupsIds = $autoGroups->pluck('group_id')->toArray();
    $weightSum = array_sum(array_column($autoGroups->toArray(), 'weight'));
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
{{--                        Количество регистраций, которое прошло с момента последнего изменения правил--}}
{{--                        Процент этих регистраций, от общего количества регистраций--}}
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
                                    $percentage = 0;
                                    if ($weightSum > 0) {
                                        $percentage = round((($autoGroup->weight / $weightSum ) * 100), 1);
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $autoGroup->labelSecured }}</td>
                                    <td>
                                        <input class="form-control auto-group-data-input" data-groupId="{{ $autoGroup->group_id }}" type="number" value="{{ $autoGroup->weight }}" min="1"/>
                                    </td>
                                    <td>{{ $percentage }} %</td>
                                    <td>1</td>
                                    <td>10 %</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Total weight</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ array_sum(array_column($autoGroups->toArray(), 'weight')) }}</td>
                            </tr>
                            <tr>
                                <td>Total registrations</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $playersCount }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 text-right">
                <button type="button" class="btn btn-info update-autogroups-data-btn">Update (will reset current registration context)</button>
                <a href="{{ url('/adminpanel/groups') }}" class="btn btn-danger">Reset</a>
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
