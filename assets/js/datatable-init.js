// $(document).ready(function () {
//     const table = $('#dataTable');
//     const containerWidth = table.parent().width();

//     const clone = table.clone()
//         .css({
//             visibility: 'hidden',
//             position: 'absolute',
//             width: '100%'
//         })
//         .appendTo('body');

//     const tableWidth = clone.width();
//     clone.remove();

//     const enableScrollX = tableWidth > containerWidth;
//     table.DataTable({
//         scrollX: enableScrollX
//     });
// })

$(document).ready(function () {
    if (!$.fn.DataTable.isDataTable('#dataTable')) {
        $('#dataTable').DataTable({
            scrollX: true,
            autoWidth: false
        });
    }
});