$(function() {
    "use strict";

    //Make the dashboard widgets sortable Using jquery UI
    $(".connectedSortable").sortable({
        placeholder: "sort-highlight",
        connectWith: ".connectedSortable",
        handle: ".box-header, .nav-tabs",
        forcePlaceholderSize: true,
        zIndex: 999999
    }).disableSelection();
    $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

    //Set language flag to multilang fields
    var flagImage = $('.langFlag').val();
    if(flagImage.length > 0) {
        $(".mlang").each(function () {
            $(this).css({"background-image": "url(" + flagImage + ")", "background-repeat": "no-repeat", "background-position": "99% 10px", "background-size": "16px 11px"});
        });
    }

    //@TODO: Do it multilang by setting from layout params.
    $('.dataTable').DataTable({
        "stateSave": true,
        "columnDefs": [{
            "orderable": false,
            "targets": "unsorted"
        }],
        "language": {
            "emptyTable":     "Данные отсутствуют",
            "info":           "Показано с _START_ по _END_ из _TOTAL_ записей",
            "infoEmpty":      "Данные отсутствуют",
            "infoFiltered":   "(отфильтровано из _MAX_ записей)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Показывать по _MENU_ записей",
            "loadingRecords": "Загрузка...",
            "processing":     "Обработка...",
            "search":         "Поиск:",
            "zeroRecords":    "Нет совпадений",
            "paginate": {
                "first":      "Начало",
                "last":       "Конец",
                "next":       "Следующая",
                "previous":   "Предыдущая"
            },
            "aria": {
                "sortAscending":  ": отсортировать по возрастанию",
                "sortDescending": ": отсортировать по убыванию"
            }
        }
    });

});