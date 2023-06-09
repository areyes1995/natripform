var status_changed = false;

$(function(){
    setTimeout(() => {
        startWizard();
        $('.wizard-form').show()
    }, 2000);
});

const startWizard=()=> {
    $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        // transitionEffect: "fade",
        enableAllSteps: true,
        autoFocus: true,
        // transitionEffectSpeed: 100,
        titleTemplate : '<span class="title">#title#</span>',
        labels: {
            previous : 'Anterior',
            next : `Siguiente <div class="loader"><span class="spinner-border text-light" role="status"><span></div>`,
            finish : 'Finalizar <div class="loader"><span class="spinner-border text-light" role="status"><span></div>',
            current : ''
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            let validate = null;
            let formData = $('.form-register').serializeArray(); $('.form-error').html(null);

            if (newIndex > 0) {
                $('.actions ul li:nth-child(1)').css({'opacity': 1});
            } else {
                $('.actions ul li:nth-child(1)').css({'opacity': 0.3});
            }

            if (status_changed) {
                return true;
            }

            if (currentIndex == 0 && status_changed === false) {
                validate = firstStepValidate(formData);
                
                if (!ifErrorExists(validate)) {
                    $('.loader').css({'display': 'inline-block'});
                    
                    $.post('backend/validate.php?valid', formData, function(data) {
                        data = JSON.parse(data);

                        if (data.data?.consultation_id > 0) {
                            status_changed = true;

                            secondStep(data.data);

                            setTimeout(() => {
                                $("#form-total").steps("next");
                            }, 1000);
                        } else {
                            $('.form-error').append('<i class="far fa-engine-warning"></i> <b>Wrong Validation provided</b><br>').css({'display': 'block'});
                        }
                    })
                    .fail(function() {
                        alert( "Request error: validating error" );
                    });

                    setTimeout(() => {
                        $('.loader').css({'display': 'none'});
                    }, 1000);
                }
            } 
            else {
                return true;
            } 
            // if (status_changed){
            //     return true;
            // }
        },
        onStepChanged: function (event, currentIndex, newIndex) {
            status_changed = false;
        }
    // $("#date").datepicker({
    //     dateFormat: "MM - DD - yy",
    //     showOn: "both",
    //     buttonText : '<i class="zmdi zmdi-chevron-down"></i>',
    // });
    });
}

const firstStepValidate=(data)=> {
    var constraints = {
        natrip_id: {
            presence: true,
            length: {
                minimum: 13,
                message: "must be at least 13 characters"
            }
        },
        cedula: {
            presence: true,
            length: {
                minimum: 6,
                message: "must be at least 6 characters"
            }
        }
    };
    
    let formData = [];
    for (item of data) {
        if (constraints.hasOwnProperty(item.name)) {
            formData[item.name] = item.value;
        }
    }

    formData = validate(formData, constraints);
    return formData !== undefined ? formData : true;
}

const ifErrorExists=(validate)=> {
    if (validate !== null && validate !== true) {
        $('.form-error').html(null);
        for (item in validate) {
            $('.form-error').append('<i class="far fa-engine-warning"></i> <b>'+validate[item][0]+'</b><br>').css({'display': 'block'});
        }

        return true;
    }

    return false;
}

const secondStep=(data)=> {
    $('#fullname-val').html(`${data.name} ${data.last_name}`);
    $('#phone-val').html(data.phone);
    $('#email-val').html(data.email);
    $('#status-val').html(data.status);
}