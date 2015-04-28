(function($) {

//jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    $(".next").click(function() {
        var name = $('#fos_user_registration_form_username').val();
        var email = $('#fos_user_registration_form_email').val();
        var pwd = $('#fos_user_registration_form_plainPassword_first').val();
        var Confirmpwd = $('#fos_user_registration_form_plainPassword_second').val();
        var filter = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i



        if (name == '') {
            $('#fos_user_registration_form_username').css({'background': 'rgba(192, 33, 0, 0.3)'});

            $('#fos_user_registration_form_username').addClass('inscri-plac');
            $('#fos_user_registration_form_username').attr("placeholder", "Champ obligatoire").placeholder();
            return false;
        }
        else {
            $('#fos_user_registration_form_username').css({'background': '#fff'});
        }
        if (email == '') {
            $('#fos_user_registration_form_email').css({'background': 'rgba(192, 33, 0, 0.3)'});
            $('#fos_user_registration_form_email').addClass('inscri-plac');
            $('#fos_user_registration_form_email').attr("placeholder", "Champ obligatoire").placeholder();
            return false;
        }
        else {
            $('#fos_user_registration_form_email').css({'background': '#fff'});
        }
        if (!filter.test(email))
        {
            $('#fos_user_registration_form_email').css({'background': 'rgba(192, 33, 0, 0.3)'});
            $('#fos_user_registration_form_email').val("");
            $('#fos_user_registration_form_email').addClass('inscri-plac');
            $('#fos_user_registration_form_email').attr("placeholder", "email invalid (exemple@gmail.com)").placeholder();
            return false;
        }
        if (pwd == '') {
            $('#fos_user_registration_form_plainPassword_first').css({'background': 'rgba(192, 33, 0, 0.3)'});
            $('#fos_user_registration_form_plainPassword_first').addClass('inscri-plac');
            $('#fos_user_registration_form_plainPassword_first').attr("placeholder", "Champ obligatoire").placeholder();
            return false;
        }
        else {
            $('#fos_user_registration_form_plainPassword_first').css({'background': '#fff'});
        }
        if (Confirmpwd != pwd) {
            $('#fos_user_registration_form_plainPassword_second').css({'background': 'rgba(192, 33, 0, 0.3)'});
            $('#fos_user_registration_form_plainPassword_first').css({'background': 'rgba(192, 33, 0, 0.3)'});
            $('#fos_user_registration_form_plainPassword_second').val("");
            
            $('#fos_user_registration_form_plainPassword_second').addClass('inscri-plac');
          
            $('#fos_user_registration_form_plainPassword_second').attr("placeholder", "Mot de passe pas identique").placeholder();
            return false;
        }
        else {
            $('#fos_user_registration_form_plainPassword_second').css({'background': '#fff'});
            $('#fos_user_registration_form_plainPassword_first').css({'background': '#fff'});
        }
        if (animating)
            return false;
        animating = true;

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'transform': 'scale(' + scale + ')'});
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
        $("#fos_user_registration_form_lat").val(pos.k);
        $("#fos_user_registration_form_lng").val(pos.D);
        geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(pos.k, pos.D);
        //latlng = event.latLng;

        geocoder.geocode({
            'latLng': latlng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                 $("#paysregion").val(results[3].formatted_address);
                if (results[0]) {

                    $("#fos_user_registration_form_adresse").val(results[0].formatted_address);
                   

                } else {
                    alert('No results found');
                }
            } else {
                alert('Geocoder failed due to: ' + status);
            }

        });

    });
    $(".nexte").click(function() {
        var nom = $('#fos_user_registration_form_nom').val();
        var prenom = $('#fos_user_registration_form_prenom').val();
        if (nom == '') {
            $('#fos_user_registration_form_nom').css({'background': 'rgba(192, 33, 0, 0.3)'});
            $('#fos_user_registration_form_nom').addClass('inscri-plac');
            $('#fos_user_registration_form_nom').attr("placeholder", "Champ obligatoire").placeholder();
            return false;
        }
        else {
            $('#fos_user_registration_form_nom').css({'background': '#fff'});
        }
        if (prenom == '') {
            $('#fos_user_registration_form_prenom').css({'background': 'rgba(192, 33, 0, 0.3)'});
            $('#fos_user_registration_form_prenom').addClass('inscri-plac');
            $('#fos_user_registration_form_prenom').attr("placeholder", "Champ obligatoire").placeholder();
            return false;
        }
        else {
            $('#fos_user_registration_form_prenom').css({'background': '#fff'});
        }


        if (animating)
            return false;
        animating = true;

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'transform': 'scale(' + scale + ')'});
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });

    });

    $(".previous").click(function() {
        if (animating)
            return false;
        animating = true;

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1 - now) * 50) + "%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'left': left});
                previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".submit").click(function() {
        return false;
    })

})(jQuery);

