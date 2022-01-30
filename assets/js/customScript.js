var $window = $(window);
$window.on("load",function (){
    $(".preloader").fadeOut(500);
});
$(document).ready(function(){
    var date = $('#month').val();

    $('#personnelTable').DataTable();

    $('#attendanceTable').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "oLanguage": {
                    "sLengthMenu": "_MENU_ Entries"
                },
                dom: 'Blfrtip',
                buttons: [
                    { 
                        "extend": 'csv', 
                        "text":'CSV',
                        "filename": 'attendance_report',
                        "title":'Attendance Report',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                           
                        },
                    },
                    {
                        "extend": 'copy',
                        "text":'Copy',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                        }
                    },
                    { 
                        "extend": 'print', 
                        "text":'PRINT',
                        "filename": 'attendance_report',
                        "title":'Attendance Report',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                           
                        },
                    },
                    { 
                        "extend": 'pdf', 
                        "text":'PDF',
                        "filename": 'attendance_report',
                        "title":'Attendance Report',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                           
                        },
                    }
                ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": SITE_URL+"attendance/get_attendance",
            "type": "POST",
            "dataType": "json",
            "data": {date:date},
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });
    $('#bioTable').DataTable({ 
 
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "oLanguage": {
                    "sLengthMenu": "_MENU_ Entries"
                },
                dom: 'Blfrtip',
                buttons: [
                    { 
                        "extend": 'csv', 
                        "text":'CSV',
                        "filename": 'attendance_report',
                        "title":'Attendance Report',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                           
                        },
                    },
                    {
                        "extend": 'copy',
                        "text":'Copy',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                        }
                    },
                    { 
                        "extend": 'print', 
                        "text":'PRINT',
                        "filename": 'attendance_report',
                        "title":'Attendance Report',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                           
                        },
                    },
                    { 
                        "extend": 'pdf', 
                        "text":'PDF',
                        "filename": 'attendance_report',
                        "title":'Attendance Report',
                        "className": 'btn btn-primary btn-sm text-light mb-2',
                        "exportOptions": {
                            "columns": [0,1,2,3,4,5],
                           
                        },
                    }
                ],
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": SITE_URL+"biometrics/get_bio",
            "type": "POST",
            "dataType": "json",
            "data": {date:date},
        },
 
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });

    $('#attendanceTable1').DataTable({
        "order": [
            [ 0, "desc" ],
            [ 1, "asc" ],
        ],
        "oLanguage": {
            "sLengthMenu": "_MENU_ Entries"
        },
        dom: 'Blfrtip',
        buttons: [
            { 
                "extend": 'csv', 
                "text":'CSV',
                "filename": 'attendance_report',
                "title":'Attendance Report',
                "className": 'btn btn-primary btn-sm text-light mb-2',
                "exportOptions": {
                    "columns": [0,1,2,3,4],
                   
                },
            },
            {
                "extend": 'copy',
                "text":'Copy',
                "className": 'btn btn-primary btn-sm text-light mb-2',
                "exportOptions": {
                    "columns": [0,1,2,3,4],
                }
            },
            { 
                "extend": 'print', 
                "text":'PRINT',
                "filename": 'attendance_report',
                "title":'Attendance Report',
                "className": 'btn btn-primary btn-sm text-light mb-2',
                "exportOptions": {
                    "columns": [0,1,2,3,4],
                   
                },
            },
            { 
                "extend": 'pdf', 
                "text":'PDF',
                "filename": 'attendance_report',
                "title":'Attendance Report',
                "className": 'btn btn-primary btn-sm text-light mb-2',
                "exportOptions": {
                    "columns": [0,1,2,3,4],
                   
                },
            }
        ]
    });

    setTimeout(function(){ $('.alert').fadeOut('slow'); }, 3000);


    $('#basic').select2({
        theme: "bootstrap",
        dropdownParent: $('#addAttendance')
    });
    $('#basic2').select2({
        theme: "bootstrap",
        dropdownParent: $('#editAttendance')
    });
	$('#importCSV').click(function(){
		$(".preloader").show();
	})
});

$('#month').blur(function(){
    var date = $(this).val();
    var url = window.location.href;
    var newUrl = url.split('?')[0];
    window.location.href = newUrl+'?date='+date;
});

function printDiv(divName) {

    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}