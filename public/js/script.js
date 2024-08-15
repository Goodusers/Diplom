

$(document).ready(function() {

    $('#phone').mask(' +7 (999) 999-99-99');

    $.fn.setCursorPosition = function(pos) {
      if ($(this).get(0).setSelectionRange) {
        $(this).get(0).setSelectionRange(pos, pos);
      } else if ($(this).get(0).createTextRange) {
        var range = $(this).get(0).createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
      }
    };
    
    
    $('input[type="tel"]').click(function(){
        $(this).setCursorPosition(5);  // Установка позиции
      });

      function windowH() {
        var wH = $(window).height();
     
        $('body').css({height: wH});
     }
    
     windowH();

     // Модальное окно
    $('.modal-edit').slideUp();

    $('#open-modal-edit').click(function(){
      $('.modal-edit').slideDown(6);
    });
    $('#send').click(function(){
      $('.modal-edit').slideUp();
    });
    $('.exit-button').click(function(){
      $('.modal-edit').slideUp();
    });
    // _____________________________________

    // Модальное окно добавленияя фото
    $('.add_photo').slideUp();

    $('#button-open-window-add-photo').click(function(){
      $('.add_photo').slideDown(6);
    });
    $('#send-photo').click(function(){
      $('.add_photo').slideUp();
    });
    $('.exit-add-photo').click(function(){
      $('.add_photo').slideUp();
    });
    // _____________________________________

    $('.modal-fr').slideUp();
    $('#appl').click(function(){
      $('.modal-fr').slideDown(6);
    });
    $('#close_friend-icon').click(function(){
      $('.modal-fr').slideUp();
    });
    // Ajax на изменение данных пользователя
    $('.change-data-user').on('submit', function(event) {
      event.preventDefault();
      
      let username = $('#username').val() || '';
      let email = $('#email').val() || '';
      let phone = $('#phone').val() || '';
      let city = $('#city').val() || '';
      let token = $('#token').val() || '';
      let photo = '';
  
      // Проверка на наличие выбранного файла
      if ($('#photo')[0].files.length > 0) {
        photo = $('#photo')[0].files[0].name;
      }
  
      $.ajax({
        url: "/change_my_data",
        type: "POST",
        data: {
          username: username,
          email: email,
          phone: phone,
          city: city,
          token: token,
          photo: photo,
          _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function(data) {
          // Обновление UI с новыми данными пользователя
          $('#name-user-name').text(username);
          $('#user-city').text('город: ' + city);
          console.log(photo);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          // Обработка ошибки
          console.error('Ошибка при обновлении данных пользователя: ' + textStatus, errorThrown);
        }
      });
    });
    $('.model-access-friend').slideUp();

    $(document).on('click', '.paper svg', function() {
      var $paperBlock = $('.paper-block');
      if ($paperBlock.css('display') === 'none') {
        $paperBlock.css('display', 'flex'); // Показываем элемент
        $('.download-photo').on('click', function(){
          $paperBlock.css('display', 'none'); // Скрываем элемент
        })
      } else {
        $paperBlock.css('display', 'none'); // Скрываем элемент
        
      }
    });

    $(document).on('click', '.settings_block svg', function() {
      var $paperBlock = $('.container-settings');
      if ($paperBlock.css('display') === 'none') {
        $paperBlock.css('display', 'flex'); // Показываем элемент
        $('.download-background').on('click', function(){
          $paperBlock.css('display', 'none'); // Скрываем элемент
        })
      } else {
        $paperBlock.css('display', 'none'); // Скрываем элемент
        
      }
    });
  
    $(document).on('click', '.title small', function() {
      var $paperBlock = $('.uchastniki');
      if ($paperBlock.css('display') === 'none') {
        $paperBlock.css('display', 'flex'); // Показываем элемент
        $('.download-background').on('click', function(){
          $paperBlock.css('display', 'none'); // Скрываем элемент
        })
      } else {
        $paperBlock.css('display', 'none'); // Скрываем элемент
        
      }
    });
    $(document).on('click', '.more-info', function() {
      var $paperBlock = $('.acc_friend');
      if ($paperBlock.css('display') === 'none') {
        $paperBlock.css('display', 'flex'); // Показываем элемент
        $('.download-background').on('click', function(){
          $paperBlock.css('display', 'none'); // Скрываем элемент
        })
      } else {
        $paperBlock.css('display', 'none'); // Скрываем элемент
        
      }
    });
    $('#close-accepted-del-history').on('click', function(){
      $('.accepted-del-history').css('display', 'none'); // Скрываем элемент
    })

    $('#close-accepted-del-history-comm').on('click', function(){
      $('.madal_community_del').css('display', 'none'); // Скрываем элемент
    })
    $('#close-accepted-del-history-exit').on('click', function(){
      $('.madal_community_exit').css('display', 'none'); // Скрываем элемент
    })
    $('#del-history').on('click', function(){
      $('.accepted-del-history').css('display', 'flex'); // Скрываем элемент
    })
    $('#next-accepted-del-history').on('submit', function(event){
      event.preventDefault();

      let user_id = $('#user_id').val();
      let friend_id = $('#friend_id').val();
      let chat_id = $('#chat_id').val();
      
      $.ajax({
        url: "del_history",
        type:"POST",
        error:{
          user_id:'',
          friend_id:'',
          chat_id:'',
        },
        data:{
  
          chat_id:chat_id,
          friend_id:friend_id,
          user_id:user_id,
 
          _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (data) {
          $('.accepted-del-history').css('display', 'none'); // Скрываем элемент
        },
        error: function(error){
          alert("Введены некорректные данные");
        }
       });
    });


    $('#close-accepted-blacklist').on('click', function(){
      $('.accepted-blacklist').css('display', 'none'); // Скрываем элемент
    })

    $('#blocked').on('click', function(){
      $('.accepted-blacklist').css('display', 'flex'); // Скрываем элемент
    })

    $('#next-accepted-blacklist').on('submit', function(event){
      event.preventDefault();

      let user_id = $('#user_id').val();
      let friend_id = $('#friend_id').val();
      let chat_id = $('#chat_id').val();
      
      $.ajax({
        url: "blacklist",
        type:"POST",
        error:{
          user_id:'',
          friend_id:'',
          chat_id:'',
        },
        data:{
  
          chat_id:chat_id,
          friend_id:friend_id,
          user_id:user_id,
 
          _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (data) {
          $('.accepted-blacklist').css('display', 'none'); // Скрываем элемент
        },
        error: function(error){
          alert("Введены некорректные данные");
        }
       });
    });
    $('#unblocked').on('submit', function(event){
      event.preventDefault();

      let chat_id = $('#chats_id').val();
      
      $.ajax({
        url: "unblacklist",
        type:"POST",
        error:{
          chat_id:'',
        },
        data:{
  
          chat_id:chat_id,
 
          _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (data) {
          $('.accepted-blacklist').css('display', 'none'); // Скрываем элемент
        },
        error: function(error){
          alert("Введены некорректные данные");
        }
       });
    });
    $('.reset-password').on('click', function(event){
      event.preventDefault();
      $('.signin_block').css('display','none');
      $('.model-password-rest').css('display','flex');
    })  
    $('#emailClose').on('click', function(e){
      e.preventDefault();
      $('.signin_block').css('display','flex');
      $('.model-password-rest').css('display','none');
    })
    $('#emailReset').on('submit', function(e){
      e.preventDefault();
      let two_email = $('#two_email').val();
      $.ajax({
        url: "resetPassword",
        type:"post",
        data:{
          two_email:two_email,
 
          _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (data) {
            $('.model-password-rest').css('display','flex');
          
        },
        error: function (){
          console.log('ura')
          
        }
      });
    })

    $('#change-background').on('click', function(){
      $('#change-background').css('display', 'none'); // Скрываем элемент
      $('#change-background-add').css('display', 'flex'); // Скрываем элемент
    })

    $('#change-background-add').on('submit', function( event ){
      $('#change-background').css('display', 'flex'); // Скрываем элемент
      $('#change-background-add').css('display', 'none'); // Скрываем элемент

      event.preventDefault();
      let chat_id = $('#chatss_id').val();
      let users_id = $('#users_id').val();
      let image = $('#image').val();
      
      $.ajax({
        url: "background",
        type:"POST",
        error:{
          chat_id:'',
        },
        data:{
  
          chat_id:chat_id,
          user_id:user_id,
          image:image,
 
          _token: $('meta[name="csrf-token"]').attr('content') 
        },
        success: function (data) {
          // $('.accepted-blacklist').css('display', 'none'); // Скрываем элемент
          $('.message-block-wrap').css('background-image', 'url(' + image + ')');
        },
        error: function(error){
          alert("Введены некорректные данные");
        }
       });
    });
    $('#my_friends').click(function(){
      $('.add_photo').css();
    });

    $('#button_addCommunity').click(function(){
      $('.modal-window-add-community').css('display', 'flex');
    });
    $('.exit-add-community').click(function() {
      $('.modal-window-add-community').css('display', 'none');
    } );

    // ____________community_______________
    //_____________icon____________________
    $('#interface').click(function() {
      $('.madal_community_interface').css('display', 'flex');
    });
    $('#add_user').click(function() {
      $('.madal_community_add_user').css('display', 'flex');
    });
    $('#del_community').click(function() {
      $('.madal_community_del').css('display', 'flex');
    });
    $('#exit_community').click(function() {
      $('.madal_community_exit').css('display', 'flex');
    });
    //____________________________________
    //____________button__________________
    $('#exit_interface').click(function() {
      $('.madal_community_interface').css('display', 'none');
    });
    $('#exit_add_user').click(function() {
      $('.madal_community_add_user').css('display', 'none');
    });
    $('#exit_del').click(function() {
      $('.madal_community_del').css('display', 'none');
    });
    $('#exit_exit').click(function() {
      $('.madal_community_exit').css('display', 'none');
    });
    //_____________________________________

});