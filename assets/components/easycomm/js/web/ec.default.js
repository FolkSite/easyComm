var easyComm = {
    initialize: function(){
        if(!jQuery().ajaxForm) {
            easyComm.notice.error('Can`t find jQuery ajaxForm plugin!');
        }
        easyComm.rating.initialize();
        $(document).on('submit', 'form.ec-form', function(e){
            easyComm.message.send(this);
            e.preventDefault();
            return false;
        });
    },

    message: {
        send: function(form) {
            $(form).ajaxSubmit({
                data: {action: 'message/create'}
                ,url: easyCommConfig.actionUrl
                ,form: form
                ,dataType: 'json'
                ,beforeSubmit: function() {
                    $(form).find('input[type="submit"]').attr('disabled','disabled');
                    $(form).find('.has-error').removeClass('has-error');
                    $(form).find('.ec-error').text('').hide();
                    return true;
                }
                ,success: function(response) {
                    var fid = $(form).data('fid');
                    $(form).find('input[type="submit"]').removeAttr('disabled');
                    if (response.success) {
                        $(form)[0].reset();
                        if(typeof (response.data) == "string") {
                            $('#ec-form-success-' + fid).html(response.data);
                            $(form).hide();
                        }
                        else {
                            easyComm.notice.show(response.message);
                        }
                    }
                    else {
                        if(response.data && response.data.length) {
                            $.each(response.data, function(i, error) {
                                $(form).find('[name="' + error.field + '"]').closest('.form-group').addClass('has-error');
                                $(form).find('#ec-' + error.field + '-error-' + fid).text(error.message).show();
                            });
                        } else {
                            easyComm.notice.error(response.message);
                        }
                    }
                }
                ,error: function(){
                    $(form).find('input[type="submit"]').removeAttr('disabled');
                    easyComm.notice.error('Submit error');
                }
            });
        }
    },


    rating: {
        initialize: function(){
            var stars = $('.ec-rating').find('.ec-rating-stars>span');
            stars.on('touchend click', function(e){
                var starDesc = $(this).data('description');
                $(this).parent().parent().find('.ec-rating-description').html(starDesc).data('old-text', starDesc);
                $(this).parent().children().removeClass('active active2 active-disabled');
                $(this).prevAll().addClass('active');
                $(this).addClass('active');
                // save vote
                var storageId = $(this).closest('.ec-rating').data('storage-id');
                $('#' + storageId).val($(this).data('rating'));
            });
            stars.hover(
                // hover in
                function() {
                    var descEl = $(this).parent().parent().find('.ec-rating-description');
                    descEl.data('old-text', descEl.html());
                    descEl.html($(this).data('description'));
                    $(this).addClass('active2').removeClass('active-disabled');
                    $(this).prevAll().addClass('active2').removeClass('active-disabled');
                    $(this).nextAll().removeClass('active2').addClass('active-disabled');
                },
                // hover out
                function(){
                    var descEl = $(this).parent().parent().find('.ec-rating-description');
                    descEl.html(descEl.data('old-text'));
                    $(this).parent().children().removeClass('active2 active-disabled');
                }
            );
        }
    },

    notice: {
        error: function(text) {
            alert(text);
        },
        show: function(text) {
            alert(text);
        }
    }
}

$(document).ready(function(){
    easyComm.initialize();
});
