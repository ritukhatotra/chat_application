var url = 'http://localhost/chat_application/';
$(function () {
    $("#login-form").validate({
        ignore: [],
        rules: {
            email: {
                required: true,
                email:true
            },
            password: "required"
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});

$(function () {
    $("#reg-form").validate({
        ignore: [],
        rules: {
            first_name: {
                required: true,
            },
            email: {
                required: true,
                email:true
            },
            password: {
                required: true,
                minlength:8
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});

$(document).on('blur','#email', function(){
    var email = $(this).val();
    if(email.length > 0) {
        $.ajax({
            type: 'post',
            url: url+'checkEmail',
            data:{email: email},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if(data === 'exist') {
                    $('#error-email').show();
                    $('#error-email').html('Email already exist. Try another!')                
                } else {
                    $('#error-email').hide();
                }
    
            }
        }) 
    } else {
         $('#error-email').hide();
    }
});

function startChat(user_id) {
    $.ajax({
        type: 'post',
        url: url+'user/get-user-chat',
        data:{user_id: user_id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $('.conversation').html(data);
        }
    }); 
}

function sendMessage(sender_id,receiver_id) {
    var inp = $('#comment').val();
    $.ajax({
        type: 'post',
        url: url+'user/send-message',
        data:{sender_id: sender_id, receiver_id: receiver_id, message: inp},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $(".side").load(location.href + " .side");

            $('.conversation').html(data);
        }
    }); 
}

function deleteMsg(chat_id,user_id) {
    $.ajax({
        type: 'get',
        url: url+'user/delete-sender-message/'+user_id+'/'+chat_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            $(".msg_"+chat_id).hide();
        }
    }); 
}


