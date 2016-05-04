$(document).ready(function() {

  //table configuration
  $('#dataTables-example').DataTable({
    responsive: true
  });

  //element selection
  var $modalUserForm = $('#modal-user-form');
  var $modalTxtUsername = $('#modal-txt-username');
  var $modalTxtLastname = $('#modal-txt-lastname');
  var $modalTxtPassword = $('#modal-txt-password');
  var $modalCbbRole = $('#modal-cbb-role');
  var editId = 0;

  //onDelete
  $('.btn-user-delete').on('click', function(){
    var target = $(this);
    var id = target.data('id');

    //confirm
    var result = confirm("Are you sure to want to delete the user ?");
    if (result == true) {
      $.ajax({
        method: "POST",
        url: "/UserController/delete",
        async: false,
        /* Prevent immediate page redirect */
        data: {
          uid: id
        }

      }).done(function(response) {
        var data = response.trim();
        if(data == 'true' || parseInt(data) == 1)
        {
          $modalUserForm.modal('hide');
          window.location.href = "../User/";
        }
        else {
          alert(data);
          return false;
        }
      });
    }
  });
  //onEdit
  $('.btn-user-edit').on('click', function() {
    var target = $(this);
    var id = target.data('id');
    var username = target.data('username');
    var lname = target.data('lname');
    var role = target.data('role');

    editId = id;
    $modalTxtUsername.val(username);
    $modalTxtLastname.val(lname);
    $modalCbbRole.val(role);
    $modalUserForm.modal('show');
  })

  //onOpenUserForm
  $('#btn-user-add-new').on('click', function() {
    editId = 0;
    $modalTxtUsername.val('');
    $modalTxtLastname.val('');
    $modalCbbRole.val('');
    $modalTxtPassword.val('');
    $modalUserForm.modal('show');
  });

  //onSaveButton
  $('#modal-btn-user-save').on('click', function() {
    //validation
    var isValid = true;
    //username
    if ($modalTxtUsername.val() == '') {
      var $formGroup = $modalTxtUsername.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtUsername.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //lastname
    if ($modalTxtLastname.val() == '') {
      var $formGroup = $modalTxtLastname.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtLastname.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    if(editId == 0)
    {
      //password
      if ($modalTxtPassword.val() == '') {
        var $formGroup = $modalTxtPassword.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.removeClass('has-success').addClass('has-error');
        $formGroup.append('<span class="help-block">Required !</span>');

        isValid = false;
      } else {
        var $formGroup = $modalTxtPassword.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.addClass('valid');
        $formGroup.removeClass('has-error').addClass('has-success');
      }
    }
    //if valid -> add new or update
    if(isValid)
    {
      if(editId == 0) // insert call
      {
        $.ajax({
          method: "POST",
          url: "/index.php/UserController/add",
          async: false,
          /* Prevent immediate page redirect */
          data: {
            username: $modalTxtUsername.val(),
            password: $modalTxtPassword.val(),
            lname: $modalTxtLastname.val(),
            role: $modalCbbRole.val()
          }

        }).done(function(response) {

          var data = response.trim();
          if(data == 'true' || parseInt(data) == 1)
          {
            $modalUserForm.modal('hide');
            window.location.href = "../User/";
          }
          else {
            alert(data);
            return false;
          }
        });
      }
      else { //update call
        $.ajax({
          method: "POST",
          url: "/index.php/UserController/update",
          async: false,
          /* Prevent immediate page redirect */
          data: {
            uid: editId,
            username: $modalTxtUsername.val(),
            password: $modalTxtPassword.val(),
            lname: $modalTxtLastname.val(),
            role: $modalCbbRole.val()
          }

        }).done(function(response) {
          
          var data = response.trim();
          if(data == 'true' || parseInt(data) == 1)
          {
            $modalUserForm.modal('hide');
            window.location.href = "../User/";
          }
          else {
            alert(data);
            return false;
          }
        });
      }

    }

  });


});
