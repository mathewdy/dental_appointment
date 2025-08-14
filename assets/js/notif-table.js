let table = $('#notif-table').DataTable({
    ajax: {
        url: 'http://localhost/dental_appointment/includes/notifications.php',
        dataSrc: function(json) {
            let flattened = [];
            json.forEach(item => {
                item.data.forEach(d => {
                    flattened.push({
                        type: d.type,
                        message: d.message,
                        datetime: d.datetime,
                        url: d.url
                    });
                });
            });
            return flattened;
        }
    },
    columns: [
        { data: 'type' },
        { data: 'message' },
        { data: 'datetime' },
    ]
});

$('#notif-table tbody').on('click', 'tr', function () {
    let rowData = table.row(this).data();
    if (rowData && rowData.url) {
        var link = 'admin/' + rowData.url
        window.location.href = link;
    }
});
