$("#create_personnel_form").validate({
    highlight: function(element) {
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
    },
    success: function(element) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    }
});


function editPersonnel(that){
    var id = $(that).attr('data-id');

    $.ajax({
        type: "POST",
        url: SITE_URL+"personnel/getPersonnel",
        dataType: "json",
        data: {id:id},
        success: function(response) {
            console.log(response.data);
            $('#lname').val(response.data.lastname);
            $('#fname').val(response.data.firstname);
            $('#mname').val(response.data.middlename);
            $('#position').val(response.data.position);
            $('#email').val(response.data.email);
            $('#fb_url').val(response.data.fb);
            $('#personnel_id').val(response.data.id);
            $('#status').val(response.data.status);
            $('#bio').val(response.data.bio_id);
        }
    });
}

function editAttendance(that){
    var id = $(that).attr('data-id');

    $.ajax({
        type: "POST",
        url: SITE_URL+"attendance/getAttendance",
        dataType: "json",
        data: {id:id},
        success: function(response) {
            console.log(response.data);
            $("#basic2").val(response.data.email).trigger('change');
            $('#date').val(response.data.date);
            $('#morning_in').val(response.data.morning_in != '00:00:00' ? response.data.morning_in : '');
            $('#morning_out').val(response.data.morning_out != '00:00:00' ? response.data.morning_out : '');
            $('#afternoon_in').val(response.data.afternoon_in != '00:00:00' ? response.data.afternoon_in : '');
            $('#afternoon_out').val(response.data.afternoon_out != '00:00:00' ? response.data.afternoon_out : '');
            $('#attendance_id').val(response.data.id);
        }
    });
}

function editBio(that){
    var id = $(that).attr('data-id');

    $.ajax({
        type: "POST",
        url: SITE_URL+"biometrics/getBio",
        dataType: "json",
        data: {id:id},
        success: function(response) {
            console.log(response.data);
            $("#basic2").val(response.data.bio_id).trigger('change');
            $('#date').val(response.data.date);
            $('#am_in').val(response.data.am_in != '00:00:00' ? response.data.am_in : '');
            $('#am_out').val(response.data.am_out != '00:00:00' ? response.data.am_out : '');
            $('#pm_in').val(response.data.pm_in != '00:00:00' ? response.data.pm_in : '');
            $('#pm_out').val(response.data.pm_out != '00:00:00' ? response.data.pm_out : '');
            $('#biometrics_id').val(response.data.id);
        }
    });
}