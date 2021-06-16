
function removeImage(key, id, name) {

    var result = confirm("Are you sure you want to delete this?");
    if (result) {
        var data = id + '|' + name;
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: APP_URL + '/removeImage/' + data,
            type: 'DELETE',
            data: {
                "id": id,
                "_token": token,
            },
            success: function () {
                $("#" + key).remove();
            }
        });
    }
}