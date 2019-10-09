
$(function () {
    $(document).on('change', '#customFile', function () {
        //$('.ws_form').submit();return;
        var file_data = $('#customFile').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        //form_data.append('txt', 'Super lux wooooooow !');
        //console.log(form_data);
        //$.LoadingOverlay("show");
        $("#ws_result").LoadingOverlay("show", {
            background: "rgba(165, 190, 100, 0.5)"
        });
        $.ajax({
            url: 'php/api_ws.php', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (result) {
                $('#ws_result').html(result);
                $('#customFile').val('');
                $("#ws_result").LoadingOverlay("hide", true);
            }
        });
    });

    $(document).on('click', '#tts_send', function () {
        var text_in = $('#tts_text').val();
        var form_data = new FormData();
        form_data.append('text_in', text_in);
        $.LoadingOverlay("show");
        $.ajax({
            url: 'php/api_text_to_speech.php', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (result) {
                $('#tts_result').html(result);
                $.LoadingOverlay("hide");
            }
        });
    });

    $(document).on('click', '#tas_send', function () {
        var text_in = $('#tas_text').val();
        var form_data = new FormData();
        form_data.append('text_in', text_in);
        $.LoadingOverlay("show");
        $.ajax({
            url: 'php/api_tone.php', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (result) {
                $('#tas_result').html(result);
                $.LoadingOverlay("hide");
            }
        });
    });

    $(document).on('click', '.a_toggle', function () {
        var wrapper = $(this).closest('.card');
        var target = wrapper.find('.card-body');
        target.slideToggle('slow');
    });

    $(document).on('keyup', '#bot_text', function (e) {
        e.preventDefault();
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            var text_in = $('#bot_text').val();
            var elmt = '<div class="row"><div class="alert alert-secondary" role="alert" style="float:left; width:50%">' + text_in + '</div></div>';
            $('#bot_result').append(elmt);
            var form_data = new FormData();
            form_data.append('text_in', text_in);
            $.LoadingOverlay("show");
            $.ajax({
                url: 'php/api_chatbot.php', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (result) {
                    elmt = '<div class="row"><div class="alert alert-success" role="alert" style="float:right; width:50%">' + result + '</div></div>';
                    $('#bot_result').append(elmt);
                    $('#bot_text').val('');
                    $.LoadingOverlay("hide");
                }
            });
        }
    });

    $(document).on('click', '#bot_submit', function (e) {
        e.preventDefault();
        var text_in = $('#bot_text').val();
        var elmt = '<div class="row"><div class="alert alert-secondary" role="alert" style="float:left; width:50%">' + text_in + '</div></div>';
        $('#bot_result').append(elmt);
        var form_data = new FormData();
        form_data.append('text_in', text_in);
        $.LoadingOverlay("show");
        $.ajax({
            url: 'php/api_chatbot.php', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (result) {
                elmt = '<div class="row"><div class="alert alert-success" role="alert" style="float:right; width:50%">' + result + '</div></div>';
                $('#bot_text').val('');
                $('#bot_result').append(elmt);
                $.LoadingOverlay("hide");
            }
        });
    });
});


