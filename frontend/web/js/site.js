const $name = $("#txtName");
const $resultName = $(".invalid-feedback-name");
const $email = $("#txtEmail");
const $resultEmail = $(".invalid-feedback-email");
const $gender = $("#select-gender");
const $age = $("#select-age");
const $client = $("#select-client-type");
const $driverschecked = $('input[name="drivers_name"]:checked');
const $drivers = $('input[name="drivers_name"]');

function showLoader() {
    $(".spanner").fadeIn("fast");
}
function hideLoader(data) {
  
        $(".spanner").fadeOut("fast",function(){
            //$('.modal-body').html(data);
            $('#myModalGreate').addClass('show');
        });  
  }

  function checkEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function isEmptyOrSpaces(str){
    return str === null || str.match(/^ *$/) !== null;
}
  
//   function validateName() {

//     $resultName.text("");
    
//     if(isEmptyOrSpaces($name.val())){
//         $resultName.text('Name cannot be blank');
//         $name.removeClass('is-valid');
//         $name.addClass('is-invalid');
//         return false;
//     }else{
//         $name.removeClass('is-invalid');
//         $name.addClass('is-valid');
//         return true;
//     }
  
//   }

//   function validateEmail(){
//     $resultEmail.text("");
//     if(isEmptyOrSpaces($email.val())){        
//         $email.removeClass('is-valid');
//         $email.addClass('is-invalid');
//         $resultEmail.text('Email cannot be blank');
//         return false;
//     }else{
//         if (checkEmail($email.val())) {     
//             $email.removeClass('is-invalid');
//             $email.addClass('is-valid');
//             return true;
//           } else { 
//             $email.removeClass('is-valid');
//             $email.addClass('is-invalid');
//             $resultEmail.text("Invalid Email");
//             return false;
//          }
//     }
//   }  
//   $("#txtEmail").focusout(validateEmail);
//   $("#txtName").focusout(validateName);

var canvas = document.getElementById("signature");
var signaturePad = new SignaturePad(canvas);

$('#clear-signature').on('click', function() {
    document.getElementById("sigText").value = "";
    signaturePad.clear();
});

$("body").on("touchend","#signature",function () {
    var canvas = document.getElementById("signature");
    var dataURL = canvas.toDataURL();
    document.getElementById("sigText").value = dataURL;
});
$("body").on("mouseup","#signature",function () {
    var canvas = document.getElementById("signature");
    var dataURL = canvas.toDataURL();
    document.getElementById("sigText").value = dataURL;
});


$("#submit-rating").submit(function(e) {     
    e.preventDefault(); // avoid to execute the actual submit of the form.
    e.stopImmediatePropagation();
    var form = $(this);
    var url = form.attr('action');
    var  nextURL = frontendURI + '/site/thank-you';
    var nextTitle = 'Great!';
    var nextState = {};
    //if(validateEmail() && validateName()){
        if(document.getElementById("sigText").value != ""){
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                dataType:'JSON',
                // beforeSend: function( jqXHR ) {
                //         showLoader();
                //     },
                success: function(data)
                {
                        // window.history.replaceState(nextState, nextTitle, nextURL);
                        // hideLoader(data);
                        if(data.message == 'blank'){
                            if(isEmptyOrSpaces($gender.val())){
                                $gender.removeClass('is-valid');
                                $gender.addClass('is-invalid');
                                $gender.focus();
                            }else{
                                $gender.removeClass('is-invalid');
                                $gender.addClass('is-valid');
                            }
                            if(isEmptyOrSpaces($age.val())){
                                $age.removeClass('is-valid');
                                $age.addClass('is-invalid');
                                $age.focus();
                            }else{
                                $age.removeClass('is-invalid');
                                $age.addClass('is-valid');
                            }
                            if(isEmptyOrSpaces($client.val())){
                                $client.removeClass('is-valid');
                                $client.addClass('is-invalid');
                                $client.focus();
                            }else{
                                $client.removeClass('is-invalid');
                                $client.addClass('is-valid');
                            }
                            if ($driverschecked.length === 0) {
                                $drivers.focus();
                            }
                            swal("Warning", "Please fill out all required fields...", "warning");
                        }
                        if(data.message == 'success') $('#myModalGreate').addClass('show');
                        
                }
            }); 
        }
        else{
            //alert('Signature required!');
            //console.log(form.serialize());
            swal("Warning", "Signature is required!", "warning");
        }
    //}
    // else{
    //     if(isEmptyOrSpaces($name.val())){
    //         $resultName.text('Name cannot be blank');
    //         $name.removeClass('is-valid');
    //         $name.addClass('is-invalid');
    //         $name.focus();
    //     }
    //     if(isEmptyOrSpaces($email.val())){        
    //         $email.removeClass('is-valid');
    //         $email.addClass('is-invalid');
    //         $resultEmail.text('Email cannot be blank');
    //         $email.focus();
    //     }
    //     else{
    //         if (checkEmail($email.val())) {     
    //             $email.removeClass('is-invalid');
    //             $email.addClass('is-valid');
    //           } else { 
    //             $email.removeClass('is-valid');
    //             $email.addClass('is-invalid');
    //             $resultEmail.text("Invalid Email");
    //             $email.focus();
    //          }
    //     }
    // }
});

$("#select-gender").change(function(){
    if($(this).val() == 'female'){
        $("#check-preggy").removeAttr("disabled");
    }else{
        $("#check-preggy").attr("disabled", true);
        $("#check-preggy").prop('checked', false);
    }
});

$("#select-age").change(function(){
    if($(this).val() == '60-69' || $(this).val() == '70-79' || $(this).val() == '80+'){
        $("#check-senior").removeAttr("disabled");
        $("#check-senior").prop('checked', true);
    }else{
        $("#check-senior").attr("disabled", true);
        $("#check-senior").prop('checked', false);
    }
});