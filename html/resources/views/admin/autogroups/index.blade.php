@extends('admin.layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/chosen/chosen.css') }}">
@endsection

@php
    /** @var Illuminate\Database\Eloquent\Collection $autoGroups */
    /** @var Illuminate\Database\Eloquent\Collection $allGroups */
    /** @var int $playersCount */

    $activeAutoGroupsIds = $autoGroups->pluck('group_id')->toArray();
@endphp

@section('content')

    <div class="col-lg-12" style="display: block;">
        <div class="row">
            <div class="col-lg-3 text-right">
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

        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <h1>Autogroups</h1>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Label</th>
                        <th scope="col">Weight</th>
                        <th scope="col">%</th>
                        <th scope="col"></th>
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
                                <tr>
                                    <td>{{ $autoGroup->id }}</td>
                                    <td>{{ $autoGroup->labelSecured }}</td>
                                    <td>
                                        <input class="form-control auto-group-data-input" data-groupId="{{ $autoGroup->id }}" type="text" value="{{ $autoGroup->weight }}"/>
                                    </td>
                                    <td>Percent</td>
                                    <td></td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>Total</td>
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
    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/chosen/chosen.jquery.js') }}"></script>

    <script type="application/javascript">
        var activeAutoGroupsIds = [];
        jQuery(document).ready(function(){
            jQuery(".chosen").chosen();
            $.each($(".chosen-autogroups-input option:selected"), function(){
                activeAutoGroupsIds.push({group_id: $(this).val()});
            });
        });

        /*
        * Set autogroup
        */
        $('.chosen-autogroups-input').on('change', function(evt, params) {
            console.log(params);
            if (params.selected) {
                activeAutoGroupsIds.push({group_id: params.selected});
            }
            if (params.deselected) {
                activeAutoGroupsIds = $.grep(activeAutoGroupsIds, function(e) {
                    return e.group_id != params.deselected;
                });
            }
            console.log(activeAutoGroupsIds);
        });

        $('.set-autogroups-selection-btn').on('click', function () {
            if (activeAutoGroupsIds.length === 0) {
                alert('You need to choose atleast 1 group!');
                return;
            }
            $.ajax({
                url: '/adminpanel/set-autogroups',
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    groups_data: activeAutoGroupsIds
                },
                success: function(data) {
                    window.location.reload();
                },
                error: function (ajaxContext) {
                    alert(ajaxContext.responseJSON.message);
                }
            });
        });


        /*
        * Update autogroup
        */
        $(".auto-group-data-input").on('change', function () {
            $(this).attr('value', $(this).val());
        });
        $('.update-autogroups-data-btn').on('click', function () {
            if (!confirm('R u sure?')) {
                return;
            }
            let autogroupsData = [];
            $(".auto-group-data-input").each(function() {
                autogroupsData.push({
                    group_id: $(this).attr('data-groupId'),
                    weight: $(this).attr('value')
                });
            });
            $.ajax({
                url: '/adminpanel/update-autogroups',
                type: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    autogroups_data: autogroupsData
                },
                success: function(data) {
                    window.location.reload();
                },
                error: function (ajaxContext) {
                    let response = ajaxContext.responseJSON;
                    if (typeof response.errors.autogroups_data != "undefined") {
                        alert(response.errors.autogroups_data[0]);
                    } else {
                        alert(response.message);
                    }
                }
            });
            console.log(autogroupsData)
        });

    </script>
@endsection
