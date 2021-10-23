  $(document).ready(function(){

    //Logic for showing/hiding password on login page
     var showPasswdTxt = $(".showPwd");
     var passwordField = $(".password");
     var pwdId = document.getElementById("password");
     var MessageArr = ["show password", "hide password"];
     ShowHideLoginPassword(showPasswdTxt, passwordField, pwdId, MessageArr);

     //Logic for showing/hiding OTP on confirm login page with OTP
     var showPasswdTxt = $(".showOTP");
     var passwordField = $(".OTP");
     var pwdId = document.getElementById("OTP");
     var MessageArray = ["show OTP", "hide OTP"];
     ShowHideLoginPassword(showPasswdTxt, passwordField, pwdId, MessageArray);


     function ShowHideLoginPassword(showPasswordTxt, pwdField, passwordId, dataArr){

      pwdField.bind("input", function(){
         var passwd = pwdField.val(); 
          if(passwd.length > 0 && passwordId.type === "password")
          {
            showPasswordTxt.text(dataArr[0]);
            showPasswordTxt.show();
            console.log(passwd);
            }
            if(passwd.length > 0 && passwordId.type != "password")
            {
              showPasswordTxt.text(dataArr[1]);
              showPasswordTxt.show();
              console.log(passwd);
              }
            else if(passwd.length <= 0)
            {
              showPasswordTxt.hide();
            }
      });
  
      showPasswordTxt.bind("click", function(){
         if(passwordId.type === "password"){
          passwordId.type = "text";
          showPasswordTxt.text(dataArr[1]);
        }else{
          passwordId.type = "password"; 
          showPasswordTxt.text(dataArr[0]);
        }
    });


    }


  });

  
 
