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
    if (params.selected) {
        activeAutoGroupsIds.push({group_id: params.selected});
    }
    if (params.deselected) {
        activeAutoGroupsIds = $.grep(activeAutoGroupsIds, function(e) {
            return e.group_id != params.deselected;
        });
    }
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
            _token: $('meta[name=csrf-token]').attr("content"),
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
            _token: $('meta[name=csrf-token]').attr("content"),
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
});

$('.show-all-groups-btn').on('click', function () {
    $('.all-groups-block').toggle();
});
