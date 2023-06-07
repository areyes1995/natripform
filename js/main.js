$(function(){
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
            next : 'Siguiente',
            finish : 'Finalizar',
            current : ''
        },
        onStepChanging: function (event, currentIndex, newIndex) {
            let formData = $('.form-register').serializeArray();
            if (currentIndex == 0) {
                const validate = firstStepValidate(formData);

                // console.log(formData);
                console.log(validate);
            }
            // const lol = validate({password: "bad"}, constraints);

            // console.log(lol);

            return false;
            if (newIndex > 0) {
                $('.actions ul li:nth-child(1)').css({'opacity': 1});
            } else {
                $('.actions ul li:nth-child(1)').css({'opacity': 0.3});
            }
           

            return true;
        }
    });
    // $("#date").datepicker({
    //     dateFormat: "MM - DD - yy",
    //     showOn: "both",
    //     buttonText : '<i class="zmdi zmdi-chevron-down"></i>',
    // });



});

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