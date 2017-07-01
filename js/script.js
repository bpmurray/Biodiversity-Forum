// JavaScript Document

$('document').ready(function()
{ 
    /* validation */
    if ($("#register-form")) {
       $("#register-form").validate({
         rules: {
            firstname: {
               required: true,
               minlength: 2
            },
            surname: {
               required: true,
               minlength: 2
            },
            email: {
               required: true,
               email: true
            },
            password: {
               minlength: 8,
               maxlength: 15
            },
            cpassword: {
               equalTo: '#password'
            }
         },
         messages: {
            firstname: "please enter your first name",
            surname: "please enter your family name",
            email: "please enter a valid email address",
            password:{
               required: "please provide a password - it's only used for cancellation",
               minlength: "password must have at least have 8 characters"
            },
            cpassword:{
               required: "please retype your password",
               equalTo: "password doesn't match !"
            }
          },
          submitHandler: submitForm   
       });  
    }
      
    /* form submit */
    function submitForm() {      
       var data = $("#register-form").serialize();
            
       $.ajax({
          type : 'POST',
          url  : 'register.php',
          data : data,
          beforeSend: function() {   
             $("#error").fadeOut();
             $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
          },
          success : function(data) {                  
             if (data==1) {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry email already taken !</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');
                });
             } else if (data=="registered") {
                $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Signing Up ...');
                setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("success.php"); }); ',5000);
             } else {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account');
                });
             }
          }
       });
       return false;
   }

    /* validation */
    if ($("#delete-form")) {
       $("#delete-form").validate({
         rules: {
            email: {
               required: true,
               email: true
            },
            password: {
               required: true,
               minlength: 8,
               maxlength: 15
            }
          },
          messages: {
            password:{
               required: "please provide a password",
               minlength: "password at least have 8 characters"
            },
            user_email: "please enter a valid email address",
          },
          submitHandler: deleteForm   
       });
    }
      
    /* form cancel */
    function deleteForm() {      
       var data = $("#delete-form").serialize();
            
       $.ajax({
          type : 'POST',
          url  : 'delete.php',
          data : data,
          beforeSend: function() {   
             $("#error").fadeOut();
             $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
          },
          success : function(data) {                  
             if (data==1) {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry email not found!</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Cancel registration');
                });
             } else if (data=="badpassword") {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry password incorrect!</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Cancel registration');
                });
             } else if (data=="deleted") {
                $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Cancelling ...');
                setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("deleted.php"); }); ',5000);
             } else {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Cancel registration');
                });
             }
          }
       });
       return false;
   }

    /* validation */
    if ($("#admin-form")) {
       $("#admin-form").validate({
         rules: {
            email: {
               required: true,
               email: true
            },
            password: {
               required: true,
               minlength: 8,
               maxlength: 15
            }
          },
          messages: {
            password:{
               required: "please provide a password",
               minlength: "password at least have 8 characters"
            },
            user_email: "please enter a valid email address",
          },
          submitHandler: adminForm   
       });
    }
      
    /* form cancel */
    function adminForm() {      
       var data = $("#admin-form").serialize();
            
       $.ajax({
          type : 'POST',
          url  : 'admchk.php',
          data : data,
          beforeSend: function() {   
             $("#error").fadeOut();
             $("#btn-submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
          },
          success : function(data) {                  
             if (data==1) {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry email not found!</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; List attendees');
                });
             } else if (data=="notadmin") {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; You don\'t have administrative permissions!</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; List attendees');
                });
             } else if (data=="badpassword") {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry password incorrect!</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; List attendees');
                });
             } else if (data=="loggedin") {
                $("#btn-submit").html('<img src="images/btn-ajax-loader.gif " /> &nbsp; Retrieving attendees ...');
                setTimeout('$(".form-signin").fadeOut(500, function(){ $(".signin-form").load("listall.php"); }); ',5000);
             } else {
                $("#error").fadeIn(1000, function(){
                   $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
                   $("#btn-submit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; List attendees');
                });
             }
          }
       });
       return false;
   }

});
