let jquery_datatable = $("#table1").DataTable({
    "language": {
        "paginate": {
            "previous": "‹",
            "next": "›"
        },
        "emptyTable": "Data Kosong",
        "info": "",
        "infoFiltered": "",
        "infoEmpty": "",
        "lengthMenu": "Tampilkan _MENU_ Baris Data",
        "zeroRecords": "Pencarian Tidak Ditemukan...",
    },
    "order": [],
    "columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
    }]
});
