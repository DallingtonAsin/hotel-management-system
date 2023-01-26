@extends('layouts.template')

@section('content')

@include('pages.main.messages.response')
 <div class="card"> 

 <div class="card-header">
  <div class="card-title">
    <span class="col-lg-10 text-success">
     <i class="fa fa-home"></i> |
      <span class="text-dark">
       Profile > Edit
     </span>
   </span>
</div>
 </div>

  <div class="card-body">

        <form class="profileForm" method="POST" action="{{route('profile.update', Auth::user()->id)}}" id="profileForm" enctype='multipart/form-data'>
           @csrf
            @method('put')

            <div class="card">
            <div class="card-body">

          <div class="form-group">
            <span class="text-muted">Username</span>
            <input type="hidden"  class="form-control user_id"
            name="id" value="{{Auth::user()->id}}" autocomplete="off">
            <input type="text"  class="form-control user_name"
            name="Username" value="{{Auth::user()->username}}" autocomplete="off">
          </div>

         <div class="form-group">
          <span class="text-muted">Phone Number</span>
          <input type="text" class="form-control contact" name="Contact" value="{{Auth::user()->phone_number}}" required
          autocomplete="off"
          >
        </div>

        <div class="form-group">
          <span class="text-muted">Email</span>
          <input type="text" class="form-control email" name="Email" value="{{Auth::user()->email}}"
          autocomplete="off"  required>
        </div>

        <div class="form-group">
          <span class="text-muted">Image</span>
          <input type="file" class="form-control-file" name="image" >
        </div>

            </div>
            </div>


        <p class="my-2">
          <button class="btn btn-default border border-default" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Need to change your password? click here
          </button>
        </p>
        <div class="collapse" id="collapseExample">
          <div class="card card-body">
            <div class="form-group">
               <span class="text-muted"> Old password</span>
              <input type="password" id="oldpassword" name="old_password" class="form-control oldpassword"  value="{{ old('old_password') }}"
              placeholder = "Enter your old password">
            </div>
  
  
            <div class="form-group">
               <span class="text-muted">New password</span>
              <input type="password" id="newpassword" name="new_password" class="form-control newpassword"  value="{{ old('new_password') }}"
              placeholder="Enter your new password">
          </div>
  
            <div class="form-group">
               <span class="text-muted">Confirm password</span>
              <input type="password" id="confirmpassword" name="confirm_password" class="form-control confirmpassword" value="{{ old('confirm_password') }}"
              placeholder="Confirm your password">
          </div>
          </div>
        </div>

        <div class="form-group">
            <button class="btn btn-link collapsed" type="button" 
            data-toggle="collapse" data-bs-target="#collapseTwo"
             aria-expanded="false" aria-controls="collapseTwo">
              <span class="text-decoration-none"></span>
            </button>
        </div>
        
        
        <div class="row form-group">
         <div class="col-lg-3">
         <button type="submit" class="btn btn-primary addProfileBtn"  name="addProfileBtn">Update Profile</button>
         <div class="col-lg-9">
            <span class="pl-0 errors_section text-danger"></span>
          </div>

         <div class="col-lg-9">
            <span class="pl-0 response"></span>
          </div>
        </div>



       </form>
     </div>
   </div>
 </div>


<script src="{{ asset('vendors/notify/notify.js') }}"></script>

@if(session()->get('success'))
<script>
    $(document).ready(function(){
     var div = ".response";
     var type = "success";
     var Login$erroror = "{{ session()->get('success') }}";
     ShowLoginErrorMessage(div, type, Login$erroror);
    });
</script>
@endif  


@if(session()->get('error'))
<script>
    $(document).ready(function(){
     var div = ".response";
     var type = "error";
     var Login$erroror = "{{ session()->get('error') }}";
     ShowLoginErrorMessage(div, type, Login$erroror);
    });
</script>
@endif 
<script>

  var oldpassword = document.getElementById("oldpassword");
  var newpassword = document.getElementById("newpassword");
  var confirmpassword = document.getElementById("confirmpassword");

  $('#showpassword1').click(function(){
    if (oldpassword.type === "password") {
      oldpassword.type = "text";
    }
    else {
      oldpassword.type = "password";
    }
  });

  $('#showpassword2').click(function(){
    if (newpassword.type === "password") {
      newpassword.type = "text";
    }
    else {
      newpassword.type = "password";
    }
  });

  $('#showpassword3').click(function(){
    if (confirmpassword.type === "password") {
      confirmpassword.type = "text";
    }
    else {
      confirmpassword.type = "password";
    }
  });




    // $('.addProfileBtn').click(function (e) {
    //     var id = $(".user_id").val();
    //     e.preventDefault();
    //     var Errors = validateForm();
    //     if(Errors.length == 0){
    //         if(id){
    //             UpdateProfile(id);
    //         }
    //     }else
    //     {
    //         var i;
    //         var message ="";
    //         for(i=0; i<Errors.length; i++){
    //             message += Errors[i] + "<br>";
    //         }
    //         $('.errors_section').html(message);
    //     }
    // });

     function UpdateProfile(user_id){
    $('.errors_section').html('');
    $('.addProfileBtn').html('Updating profile...');

    var Url = "{{ route('profile.update', ':id') }}";
    Url = Url.replace(':id', user_id);
    $.ajax({
          data: $('#profileForm').serialize(),
          url: Url,
          type: "PUT",
          dataType: 'json',
          success: function (data) {
              getUpdatedUserDetails(user_id);
              if(data.success){
                 displayResponse('.response', data.success, 'success');
                   $('.oldpassword').val('');
                   $('.newpassword').val('');
                   $('.confirmpassword').val('');
              }
              if(data.error){
                displayResponse('.response', data.error, 'error');
              }
              $('.addProfileBtn').html('Update Profile');
              
          },
          error: function (data) {
              console.log('Error:', data.error);
              displayResponse('.response', data.error, 'success');
              $('.addProfileBtn').html('Save Changes');
          }
      });

   }


    function validateForm(){
    var username = $('.user_name').val();
    var contact = $('.contact').val();
    var address = $('.address').val();
    var oldpassword = $('.oldpassword').val();
    var newpassword = $('.newpassword').val();
    var confirmpassword = $('.confirmpassword').val();

    var errors = [];
    if(username.length < 1){
      var usernameErr = "Please enter your name";
      errors.push(usernameErr);
    }
    if(contact.length < 1){
      var contactErr = "Please enter your contact";
      errors.push(contactErr);
    }
    if(address.length < 1){
     var addresErr = "Please enter your address";
     errors.push(addresErr);
    }

    if(oldpassword){
        if(stringIsEmpty(newpassword)== true){
           errors.push("Please enter your new password");
        }

        if(stringIsEmpty(confirmpassword) == true){
           errors.push("Please confirm your new password");
        }

        if(newpassword && confirmpassword){
          if(newpassword !== confirmpassword){
            errors.push("Please enter matching passwords");
          }
        }
    }
      return errors;
 }

 function stringIsEmpty(value){
   return value ? value.trim().length == 0: true;
 }

    function getUpdatedUserDetails(user_id){
       $.get("{{ route('profile.index') }}" +'/' + user_id +'', function (data) {
          $('.user_name').val(data.username);
          $('.email').val(data.email);
          $('.contact').val(data.tel_no);
          $('.address').val(data.address);
      });
    }
   
</script>

@endsection

