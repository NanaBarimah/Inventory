$.ajaxSetup({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

(function(w, d){


    function LetterAvatar (name, size) {

        name  = name || '';
        size  = size || 60;

        var colours = [
                "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", 
                "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"
            ],

            nameSplit = String(name).toUpperCase().split(' '),
            initials, charIndex, colourIndex, canvas, context, dataURI;


        if (nameSplit.length == 1) {
            initials = nameSplit[0] ? nameSplit[0].charAt(0):'?';
        } else {
            initials = nameSplit[0].charAt(0) + nameSplit[1].charAt(0);
        }

        if (w.devicePixelRatio) {
            size = (size * w.devicePixelRatio);
        }
            
        charIndex     = (initials == '?' ? 72 : initials.charCodeAt(0)) - 64;
        colourIndex   = charIndex % 20;
        canvas        = d.createElement('canvas');
        canvas.width  = size;
        canvas.height = size;
        context       = canvas.getContext("2d");
         
        context.fillStyle = colours[colourIndex - 1];
        context.fillRect (0, 0, canvas.width, canvas.height);
        context.font = Math.round(canvas.width/2)+"px Arial";
        context.textAlign = "center";
        context.fillStyle = "#FFF";
        context.fillText(initials, size / 2, size / 1.5);

        dataURI = canvas.toDataURL();
        canvas  = null;

        return dataURI;
    }

    LetterAvatar.transform = function() {

        Array.prototype.forEach.call(d.querySelectorAll('img[avatar]'), function(img, name) {
            name = img.getAttribute('avatar');
            img.src = LetterAvatar(name, img.getAttribute('width'));
            img.removeAttribute('avatar');
            img.setAttribute('alt', name);
        });
    };


    // AMD support
    if (typeof define === 'function' && define.amd) {
        
        define(function () { return LetterAvatar; });
    
    // CommonJS and Node.js module support.
    } else if (typeof exports !== 'undefined') {
        
        // Support Node.js specific `module.exports` (which can be a function)
        if (typeof module != 'undefined' && module.exports) {
            exports = module.exports = LetterAvatar;
        }

        // But always support CommonJS module 1.1.1 spec (`exports` cannot be a function)
        exports.LetterAvatar = LetterAvatar;

    } else {
        
        window.LetterAvatar = LetterAvatar;

        d.addEventListener('DOMContentLoaded', function(event) {
            LetterAvatar.transform();
        });
    }

})(window, document);

appFunctions = {
    initSchedule : function(){
       
    }
}

    demo = {
        initNowUiWizard: function(){
            // Code for the Validator
            var $validator = $('.card-wizard form').validate({
                  rules: {
                    jobb: {
                      required: true
                    },
                    lastname: {
                      required: true,
                      minlength: 3
                    },
                    email: {
                      required: true,
                      minlength: 3,
                    }
                },
                highlight: function(element) {
                    $(element).closest('.input-group').removeClass('has-success').addClass('has-danger');
                },
                success: function(element) {
                    $(element).closest('.input-group').removeClass('has-danger').addClass('has-success');
                }
            });
    
            // Wizard Initialization
            $('.card-wizard').bootstrapWizard({
                'tabClass': 'nav nav-pills',
                'nextSelector': '.btn-next',
                'previousSelector': '.btn-previous',
    
                onNext: function(tab, navigation, index) {
                    var $valid = $('.card-wizard form').valid();
                    if(!$valid) {
                        $validator.focusInvalid();
                        return false;
                    }
                },
    
                onInit : function(tab, navigation, index){
                    //check number of tabs and fill the entire row
                    var $total = navigation.find('li').length;
                    var $wizard = navigation.closest('.card-wizard');
    
                    first_li = navigation.find('li:first-child a').html();
                    $moving_div = $("<div class='moving-tab'></div>");
                    $moving_div.append(first_li);
                    $('.card-wizard .wizard-navigation').append($moving_div);
    
    
    
                    refreshAnimation($wizard, index);
    
                    $('.moving-tab').css('transition','transform 0s');
               },
    
                onTabClick : function(tab, navigation, index){
                    var $valid = $('.card-wizard form').valid();
    
                    if(!$valid){
                        return false;
                    } else{
                        return true;
                    }
                },
    
                onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index+1;
    
                    var $wizard = navigation.closest('.card-wizard');
    
                    // If it's the last tab then hide the last button and show the finish instead
                    if($current >= $total) {
                        $($wizard).find('.btn-next').hide();
                        $($wizard).find('.btn-finish').show();
                    } else {
                        $($wizard).find('.btn-next').show();
                        $($wizard).find('.btn-finish').hide();
                    }
    
                    button_text = navigation.find('li:nth-child(' + $current + ') a').html();
    
                    setTimeout(function(){
                        $('.moving-tab').html(button_text);
                    }, 150);
    
                    var checkbox = $('.footer-checkbox');
    
                    if( !index == 0 ){
                        $(checkbox).css({
                            'opacity':'0',
                            'visibility':'hidden',
                            'position':'absolute'
                        });
                    } else {
                        $(checkbox).css({
                            'opacity':'1',
                            'visibility':'visible'
                        });
                    }
    
                    refreshAnimation($wizard, index);
                }
              });
    
    
            // Prepare the preview for profile picture
            $("#wizard-picture").change(function(){
                readURL(this);
            });
    
            $('[data-toggle="wizard-radio"]').click(function(){
                wizard = $(this).closest('.card-wizard');
                wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
                $(this).addClass('active');
                $(wizard).find('[type="radio"]').removeAttr('checked');
                $(this).find('[type="radio"]').attr('checked','true');
            });
    
            $('[data-toggle="wizard-checkbox"]').click(function(){
                if( $(this).hasClass('active')){
                    $(this).removeClass('active');
                    $(this).find('[type="checkbox"]').removeAttr('checked');
                } else {
                    $(this).addClass('active');
                    $(this).find('[type="checkbox"]').attr('checked','true');
                }
            });
    
            $('.set-full-height').css('height', 'auto');
    
             //Function to show image before upload
    
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
    
                    reader.onload = function (e) {
                        $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
    
            $(window).resize(function(){
                $('.card-wizard').each(function(){
                    $wizard = $(this);
    
                    index = $wizard.bootstrapWizard('currentIndex');
                    refreshAnimation($wizard, index);
    
                    $('.moving-tab').css({
                        'transition': 'transform 0s'
                    });
                });
            });
    
            function refreshAnimation($wizard, index){
                $total = $wizard.find('.nav li').length;
                $li_width = 100/$total;
    
                total_steps = $wizard.find('.nav li').length;
                move_distance = $wizard.find('.nav').width() / total_steps;
                index_temp = index;
                vertical_level = 0;
    
                mobile_device = $(document).width() < 600 && $total > 3;
    
                if(mobile_device){
                    move_distance = $wizard.width() / 2;
                    index_temp = index % 2;
                    $li_width = 50;
                }
    
                $wizard.find('.nav li').css('width',$li_width + '%');
    
                step_width = move_distance;
                move_distance = move_distance * index_temp;
    
                // $current = index + 1;
                //
                // if($current == 1 || (mobile_device == true && (index % 2 == 0) )){
                    // move_distance -= 8;
                // } else if($current == total_steps || (mobile_device == true && (index % 2 == 1))){
                //     move_distance += 8;
                // }
    
                if(mobile_device){
                    vertical_level = parseInt(index / 2);
                    vertical_level = vertical_level * 38;
                }
    
                $wizard.find('.moving-tab').css('width', step_width);
                $('.moving-tab').css({
                    'transform':'translate3d(' + move_distance + 'px, ' + vertical_level +  'px, 0)',
                    'transition': 'all 0.5s cubic-bezier(0.29, 1.42, 0.79, 1)'
    
                });
            }
        },
        initDateTimePicker: function() {
            if($(".datetimepicker").length != 0){
              $('.datetimepicker').datetimepicker({
                  icons: {
                      time: "now-ui-icons tech_watch-time",
                      date: "now-ui-icons ui-1_calendar-60",
                      up: "fa fa-chevron-up",
                      down: "fa fa-chevron-down",
                      previous: 'now-ui-icons arrows-1_minimal-left',
                      next: 'now-ui-icons arrows-1_minimal-right',
                      today: 'fa fa-screenshot',
                      clear: 'fa fa-trash',
                      close: 'fa fa-remove'
                  }
              });
            }
    
            if($(".datepicker").length != 0){
              $('.datepicker').datetimepicker({
                 format: 'MM/DD/YYYY',
                 icons: {
                     time: "now-ui-icons tech_watch-time",
                     date: "now-ui-icons ui-1_calendar-60",
                     up: "fa fa-chevron-up",
                     down: "fa fa-chevron-down",
                     previous: 'now-ui-icons arrows-1_minimal-left',
                     next: 'now-ui-icons arrows-1_minimal-right',
                     today: 'fa fa-screenshot',
                     clear: 'fa fa-trash',
                     close: 'fa fa-remove'
                 }
              });
            }
    
            if($(".timepicker").length != 0){
              $('.timepicker').datetimepicker({
      //          format: 'H:mm',    // use this format if you want the 24hours timepicker
                 format: 'h:mm A',    //use this format if you want the 12hours timpiecker with AM/PM toggle
                 icons: {
                     time: "now-ui-icons tech_watch-time",
                     date: "now-ui-icons ui-1_calendar-60",
                     up: "fa fa-chevron-up",
                     down: "fa fa-chevron-down",
                     previous: 'now-ui-icons arrows-1_minimal-left',
                     next: 'now-ui-icons arrows-1_minimal-right',
                     today: 'fa fa-screenshot',
                     clear: 'fa fa-trash',
                     close: 'fa fa-remove'
                 }
              });
            }
        }
    }

    $('#notification-bell').on('click', function(){
        $.ajax({
            url : '/markAsRead',
            method : 'get',  
            success : function(data, status, xhr){
                if(!data.error){
                    $('#notification-count').css('display', 'none');
                }
            },
            error : function(err, desc){
                console.log(err);
            }
        })
    });