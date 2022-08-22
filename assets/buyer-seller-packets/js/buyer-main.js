(function($) {



    var form = $("#signup-form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        },
        rules: {
            email: {
                email: true
            }
        },
        onfocusout: function(element) {
            $(element).valid();
        },
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        stepsOrientation: "vertical",
        titleTemplate: '<div class="title"><span class="step-number">#index#</span><span class="step-text">#title#</span></div>',
        labels: {
            previous: 'Previous',
            next: 'Next',
            finish: 'Finish',
            current: ''
        },
        onStepChanging: function(event, currentIndex, newIndex) {
            if (currentIndex === 0) {
                form.parent().parent().parent().append('<div class="footer footer-' + currentIndex + '"></div>');
                if ($('#is_another_buyer').val() == '1') {
                    $('#new_buyer_vesting_container').removeClass('d-none');
                    $(".married option[value='new_buyer']").each(function() {
                        $(this).remove();
                    });
                    var new_buyer = $('#buyer_new_first_name').val()+" "+$('#buyer_new_last_name').val();
                    $('#new_buyer_name').val(new_buyer);
                    $('.married').append($("<option></option>")
                    .attr("value", "new_buyer")
                    .text(new_buyer)); 
                } else {
                    $('#new_buyer_vesting_container').addClass('d-none');
                }
            }
            if (currentIndex === 1) {
                form.parent().parent().parent().find('.footer').removeClass('footer-0').addClass('footer-' + currentIndex + '');
            }
            if (currentIndex === 2) {
                form.parent().parent().parent().find('.footer').removeClass('footer-1').addClass('footer-' + currentIndex + '');
            }
            if (currentIndex === 3) {
                form.parent().parent().parent().find('.footer').removeClass('footer-2').addClass('footer-' + currentIndex + '');
            }
            // if(currentIndex === 4) {
            //     form.parent().parent().parent().append('<div class="footer" style="height:752px;"></div>');
            // }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function(event, currentIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            // alert('Submited');
			form.submit();
        },
        onStepChanged: function(event, currentIndex, priorIndex) {

            return true;
        }
    });

    jQuery.extend(jQuery.validator.messages, {
        required: "",
        remote: "",
        email: "",
        url: "",
        date: "",
        dateISO: "",
        number: "",
        digits: "",
        creditcard: "",
        equalTo: ""
    });

	$('.dob_date_picker_div').each(function(){
		var date_id = $(this).find('.dob_birth_date').attr('id');
		var month_id = $(this).find('.dob_birth_month').attr('id');
		var year_id = $(this).find('.dob_birth_year').attr('id');
		
		$.dobPicker({
			daySelector: '#'+date_id,
			monthSelector: '#'+month_id,
			yearSelector: '#'+year_id,
			dayDefault: '',
			monthDefault: '',
			yearDefault: '',
			minimumAge: 0,
			maximumAge: 120
		});

		if($('#'+date_id).data('val')) {
			$('#'+date_id).val($('#'+date_id).data('val'));
			$('#'+date_id).change();
		}
		if($('#'+month_id).data('val')) {
			$('#'+month_id).val($('#'+month_id).data('val'));
			$('#'+month_id).change();
		}
		if($('#'+year_id).data('val')) {
			$('#'+year_id).val($('#'+year_id).data('val'));
		}
	});

	// $.dobPicker({
    //     daySelector: '#birth_date1',
    //     monthSelector: '#birth_month1',
    //     yearSelector: '#birth_year1',
    //     dayDefault: '',
    //     monthDefault: '',
    //     yearDefault: '',
    //     minimumAge: 0,
    //     maximumAge: 120
    // });
    var marginSlider = document.getElementById('slider-margin');
    if (marginSlider != undefined) {
        noUiSlider.create(marginSlider, {
              start: [1100],
              step: 100,
              connect: [true, false],
              tooltips: [true],
              range: {
                  'min': 100,
                  'max': 2000
              },
              pips: {
                    mode: 'values',
                    values: [100, 2000],
                    density: 4
                    },
                format: wNumb({
                    decimals: 0,
                    thousand: '',
                    prefix: '$ ',
                })
        });
        var marginMin = document.getElementById('value-lower'),
	    marginMax = document.getElementById('value-upper');

        marginSlider.noUiSlider.on('update', function ( values, handle ) {
            if ( handle ) {
                marginMax.innerHTML = values[handle];
            } else {
                marginMin.innerHTML = values[handle];
            }
        });
    }

	$('.buyer__show_hide_action').change(function(){
		var show_hide_div = $(this).data('action');
		if(show_hide_div) {
			if($(this).val()=='1') {
				$('.'+show_hide_div).show();
			}
			else {
				$('.'+show_hide_div).hide();
			}
		}
		
	});

	$(".phone_mask").mask('(000) 000-0000');
	$(".amount_mask").mask("#,##0", {reverse: true});
	$(".ssn").mask('000-00-0000');
})(jQuery);
