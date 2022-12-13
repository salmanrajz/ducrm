// #https://stackoverflow.com/questions/46643667/javascript-function-is-not-defined-with-laravel-mix
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//
function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $.each(msg, function (key, value) {
        $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
    });
}

window.SavingActivationLead = function(url,form,redirect){
// function SavingActivationLead(url, form, redirect) {
    if (confirm("are you sure all information accurate, Kindly make sure before proceed?")) {
        // console.log("Accepted")
        // } else {
        // console.log("Declined")
        var rizwan = document.getElementById(form);
        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(rizwan), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $("#loading_num3").show();
                // // $(".request_call").hide();
                $('.waves-button-input').prop('disabled', true);
                // $('#' + btn).prop('disabled', true);

            },
            success: function (data) {
                // alert(data);
                if ($.isEmptyObject(data.error)) {
                    alert(data.success);
                    $("#loading_num3").hide();
                    $('.waves-button-input').prop('disabled', false);
                    // window.location.href = 'https://soft.riuman.com/admin/activation'
                    window.location.href = redirect;
                } else {
                    $('.waves-button-input').prop('disabled', false);
                    // alert("S");
                    $("#loading_num3").hide();

                    printErrorMsg(data.error);
                }
            },
            error: function (data) {
                printErrorMsg(data.responseJSON);

                // alert(data.responseJSON);
                // console.log(data.responseJSON);
                // alert("fail");
            }

        });
    }

}
//
// function VerifyLeadBlog(url, form, redirect) {
//     var rizwan = document.getElementById(form);
//     tinymce.triggerSave();
//
window.VerifyLeadBlog = function (url, form, redirect) {
// function SavingActivationLead(url, form, redirect) {
    if (confirm("are you sure all information accurate, Kindly make sure before proceed?")) {
        // console.log("Accepted")
        // } else {
        // console.log("Declined")
        var rizwan = document.getElementById(form);
        tinymce.triggerSave();

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(rizwan), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            beforeSend: function () {
                $("#loading_num3").show();
                // // $(".request_call").hide();
                $('.waves-button-input').prop('disabled', true);
                // $('#' + btn).prop('disabled', true);

            },
            success: function (data) {
                // alert(data);
                if ($.isEmptyObject(data.error)) {
                    alert(data.success);
                    $("#loading_num3").hide();
                    $('.waves-button-input').prop('disabled', false);
                    // window.location.href = 'https://soft.riuman.com/admin/activation'
                    window.location.href = redirect;
                } else {
                    $('.waves-button-input').prop('disabled', false);
                    // alert("S");
                    $("#loading_num3").hide();

                    printErrorMsg(data.error);
                }
            },
            error: function (data) {
                $('.waves-button-input').prop('disabled', false);
                printErrorMsg(data.responseJSON);

                // alert(data.responseJSON);
                // console.log(data.responseJSON);
                // alert("fail");
            }

        });
    }

}

// window.setlocale = function (code) {
//     console.log(code);
// }

// alert("Zoom");
// function OnLo(){
//     alert("Zoom");
// }
// OnLo();

window.NameApi = function (url, form) {
    // alert(form);
    var rizwan = document.getElementById(form);
    $.ajax({
        type: "POST",
        url: url,
        data: new FormData(rizwan), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        beforeSend: function () {
            $("#loading_num1").show();
            // // $(".request_call").hide();
            // $('#' + btn).prop('disabled', true);
        },
        success: function (msg) {
            $("#loading_num1").hide();
            //    alert(msg);
            var k = msg.split('###');
            // console.log(k[3] + ' ' + $k[4]);
            // $("#front_id").val(k[3]);
            $("#full_name").val(k[0]);
            $("#emirate_id").val(k[1]);
            $("#emirate_expiry").val(k[2]);
            $("#dob").val(k[3]);
            // $("#name").val(k[1]);
            // $("#CustomerNameAct").val(k[1]);
            // $("#emirate_id_form").val(k[2]);
            // $("#activation_emirate_expiry").val(k[2]);
            //  $("#application_date").val(k[3] + ' ' + k[4]);
        },
        error: function (data) {
            $('.waves-button-input').prop('disabled', false);
            printErrorMsg(data.responseJSON);

            // alert(data.responseJSON);
            // console.log(data.responseJSON);
            // alert("fail");
        }
        // }
    });
    // }
    // }));
}

// function VerifyLead(url, form, redirect) {
window.VerifyLead = function (url, form,redirect) {
if (confirm("are you sure all information accurate, Kindly make sure before proceed?")) {

    var rizwan = document.getElementById(form);
    $.ajax({
        type: "POST",
        url: url,
        data: new FormData(rizwan), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false,
        beforeSend: function () {
            $("#loading_num3").show();
            // // $(".request_call").hide();
            $('.waves-button-input').prop('disabled', true);
            // $('#' + btn).prop('disabled', true);

        },
        success: function (data) {
            // alert(data);
            if ($.isEmptyObject(data.error)) {
                // alert(data.success);
                // window.location.href = data.success;
                // // window.open = data.success;
                // window.open(data.success, '_blank');
                setTimeout(() => {
                    $("#loading_num3").hide();
                    $('.waves-button-input').prop('disabled', false);
                    // alert(data.success);
                    alert("wait meanwhile we are redirecting you...");
                    window.location.href = redirect;
                }, 20);
            } else {
                $('.waves-button-input').prop('disabled', false);
                // alert("S");
                $("#loading_num3").hide();

                printErrorMsg(data.error);
            }
        }

    });
}
}



// pre_verification_js
$(".box:checked").next().addClass("blue");


//
$('#state').change(function () {
    // alert("eooo");
    $('#province').attr('disabled', this.value == "other1");
});

$("#state2").change(function () {
    $("#province2").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state3").change(function () {
    $("#province3").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state_gender").change(function () {
    //   alert("s");
    $("#p_gender3").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state4").change(function () {
    $("#province4").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state_emirates").change(function () {
    // alert("s");
    $("#province_emirates").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state_area").change(function () {
    // alert("s");
    $("#state__area").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state_language").change(function () {
    // alert("s");
    $("#province_language").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state5").change(function () {
    $("#province5").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state_emirate_num").change(function () {
    $("#province_original_id1").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state6").change(function () {
    $("#province6").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state7").change(function () {
    $("#province7").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state8").change(function () {
    $("#province8").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state9").change(function () {
    $("#province9").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state10").change(function () {
    $("#province10").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state11").change(function () {
    $("#province11").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state12").change(function () {
    $("#province12").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state13").change(function () {
    $("#province13").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state14").change(function () {
    $("#province14").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#device_duration_state").change(function () {
    $("#device_duration").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state15").change(function () {
    $("#province15").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state16").change(function () {
    $("#province16").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});

$("#state17").change(function () {
    $("#province17").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state18").change(function () {
    $("#province18").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
$("#state19").change(function () {
    $("#province19").attr("disabled", this.value == "other1");
    // or $("#flap-drop").toggle(this.value!="23");
});
//
$('#province').change(function () {
    $('#province1').val($('#province').val());
});
$('#state__area').change(function () {
    $('#state_area_hidden').val($('#state__area').val());
});

$('#province2').change(function () {
    $('#province22').val($('#province2').val());
});

$('#p_gender3').change(function () {
    $('#p_gender').val($('#p_gender3').val());
});
$('#province3').change(function () {
    $('#province33').val($('#province3').val());
});
$('#province4').change(function () {
    $('#province44').val($('#province4').val());
});
$('#province_original_id1').change(function () {
    $('#province_original_id11').val($('#province_original_id1').val());
});
$('#province5').change(function () {
    $('#province55').val($('#province5').val());
});
$('#province6').change(function () {
    $('#province66').val($('#province6').val());
});
$('#province7').change(function () {
    $('#province77').val($('#province7').val());
});
$('#province8').change(function () {
    $('#province88').val($('#province8').val());
});
$('#province9').change(function () {
    $('#province99').val($('#province9').val());
});
$('#province10').change(function () {
    $('#province100').val($('#province10').val());
});
$('#province11').change(function () {
    $('#province111').val($('#province11').val());
});
$('#province12').change(function () {
    $('#province112').val($('#province12').val());
});
$('#province13').change(function () {
    $('#province113').val($('#province13').val());
});
$('#province14').change(function () {
    $('#province114').val($('#province14').val());
});
$('#province15').change(function () {
    $('#province115').val($('#province15').val());
});
$('#province16').change(function () {
    $('#province116').val($('#province16').val());
});
$('#province17').change(function () {
    $('#province117').val($('#province17').val());
});
$('#province_emirates').change(function () {
    $('#province__emirates').val($('#province_emirates').val());
});
$('#province_language').change(function () {
    $('#province__language').val($('#province_language').val());
});
$('#province18').change(function () {
    $('#province118').val($('#province18').val());
});
$('#province19').change(function () {
    $('#province119').val($('#province19').val());
});


$(document).on('click', '#icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
    } else {
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('focus', '.panel-footer input.chat_input', function (e) {
    var $this = $(this);
    if ($('#minim_chat_window').hasClass('panel-collapsed')) {
        $this.parents('.panel').find('.panel-body').slideDown();
        $('#minim_chat_window').removeClass('panel-collapsed');
        $('#minim_chat_window').removeClass('glyphicon-plus').addClass('glyphicon-minus');
    }
});
$(document).on('click', '#new_chat', function (e) {
    var size = $(".chat-window:last-child").css("margin-left");
    size_total = parseInt(size) + 400;
    alert(size_total);
    var clone = $("#chat_window_1").clone().appendTo(".container");
    clone.css("margin-left", size_total);
});
$(document).on('click', '.icon_close', function (e) {
    //$(this).parent().parent().parent().parent().remove();
    $("#chat_window_1").remove();
});



// function imageIsLoaded1(e) {
window.imageIsLoaded1 = function (e) {
    $("#myImg1").show();
    $('#myImg1').attr('src', e.target.result);
};
$(function () {
    $("#front_img").change(function () {
        // console.log('ok');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded1;
            reader.readAsDataURL(this.files[0]);
        }
    });
});


// window.VerifyLead = function (url, form, redirect)
window.imageIsLoaded2 = function(e) {
    $("#myImg2").show();

    $('#myImg2').attr('src', e.target.result);
};
$(function () {
    $("#back_img").change(function () {
        console.log('ok');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded2;
            reader.readAsDataURL(this.files[0]);
        }
    });
});
window.imageIsLoaded3 = function(e) {
    $("#myImg3").show();

    $('#myImg3').attr('src', e.target.result);
};
$(function () {
    $("#additional_documents").change(function () {
        console.log('ok');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = imageIsLoaded3;
            reader.readAsDataURL(this.files[0]);
        }
    });
});
$('#inlineRadio1').click(function () {
    $("#fullemirateid").show();
    $("#lastfive").hide();
    $("#emirate_id_last_five").val('');
});
$('#inlineRadio2').click(function () {
    $("#lastfive").show();
    $("#fullemirateid").hide();
    $("#emirate_id").val('');


});

$("#lead_type").change(function () {
    // alert("s");
    // $("#state__area").attr("disabled", this.value == "other1");
    if(this.value == 'P2P'){
        $("#InlineRadioCheck").show();
    }else{
        $("#InlineRadioCheck").hide();
    }
    // or $("#flap-drop").toggle(this.value!="23");
});
