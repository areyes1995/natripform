$(function(){
    localStorage.setItem('status_changed', false);

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
            let formData = $('.form-main').serializeArray(); $('.form-error').html(null);

            if (newIndex > 0) {
                $('.actions ul li:nth-child(1)').css({'opacity': 1});
            } else {
                $('.actions ul li:nth-child(1)').css({'opacity': 0.3});
            }

            if (newIndex < currentIndex) {
                return true;
            }
            
            const status_changed = JSON.parse(localStorage.getItem('status_changed'));

            if (currentIndex == 0 && status_changed === false) {
                validate = firstStepValidate(formData);
                
                if (!ifErrorExists(validate)) {
                    $('.loader').css({'display': 'inline-block'});
                    
                    $.post('backend/validate.php?valid', formData, function(data) {
                        data = JSON.parse(data);

                        if (data.data?.consultation_id > 0) {
                            secondStep(data.data);
                            
                            if (data.data?.status !== null) {
                                localStorage.setItem('status_changed', null);
                            } else {
                                localStorage.setItem('status_changed', true);
                            }

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
            } else if (currentIndex >= 1 && status_changed === null) {
                return false;
            } else {
                return true;
            }
            
        },
        onStepChanged: function (event, currentIndex, newIndex) {
            status_changed = false;
        },
        onFinished: function(event, currentIndex) {
            let formData = $('.form-main').serializeArray();

            let status_error = false;
            for (item of formData) {
                if (item.value.length <= 0) {
                    alert('Hay preguntas sin completar. La pregunta u opcion número '+item.name.replace('ask-', '')+' no ha sido completada. Favor rellenarla');

                    status_error = true;

                    break;
                }
            }

            if (status_error === false) {
                $.post('backend/validate.php?save_ask', formData, function(data) {
                    data = JSON.parse(data);
                    if (data.data === true) {
                        Swal.fire({
							title: 'Guardado',
							text: 'Un representante esta revisando su solicitud, una vez sea revisada le dejaremos saber si su solicitud fue aprobada. Le enviaremos la información vía Email desde Info@agenciadeviajes.do. También puede tener más información llamando al 809-475-8831.',
							icon: 'success',
                            allowOutsideClick: false,
							confirmButtonText: 'Entendido, cerrar',
						}).then((result) => {
                            if (result) {
                                location.reload();
                            }
                        });
                    }
                });
            }
        },
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
        cedula_: {
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

        setTimeout(() => {
            $('.form-error').html(null);
        }, 3000);
        return true;
    }

    return false;
}

const secondStep=(data)=> {
    $('.autorizar-2').hide();
    $('#fullname-val').html(`${data.name} ${data.last_name}`);
    $('#phone-val').html(data.phone);
    $('#email-val').html(data.email);
    $('#status-val').html(data.status !== null ? data.status : 'Pending');
}