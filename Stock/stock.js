$(document).ready(function() {

  //table configuration
  $('#dataTables-example').DataTable({
    responsive: true
  });

  //element selection
  var $modalstockForm = $('#modal-stock-form');
  var $modalTxtBarCode= $('#modal-txt-barcode');
  var $modalTxtName = $('#modal-txt-name');
  var $modalTxtBrand = $('#modal-txt-brand');
  var $modalTxtCategory = $('#modal-txt-category');
  var $modalTxtDescription = $('#modal-txt-description');
  var $modalTxtSalesPrice = $('#modal-txt-salesprice');
  var $modalTxtQuantity = $('#modal-txt-quantity');
  var editId = 0;

  //onDelete
  $('.btn-stock-delete').on('click', function(){
    var target = $(this);
    var id = target.data('id');

    //confirm
    var result = confirm("Are you sure to want to delete the stock ?");
    if (result == true) {
      $.ajax({
        method: "POST",
        url: "deleteProcess.php",
        async: false,
        /* Prevent immediate page redirect */
        data: {
          pid: id
        }

      }).done(function(response) {
        var data = response.trim();
        if(data == 'true')
        {
          $modalstockForm.modal('hide');
          window.location.href = "../Stock/index.php";
        }
        else {
          alert(data);
          return false;
        }
      });
    }
  });
  //onEdit
  $('.btn-stock-edit').on('click', function() {
    var target = $(this);
    var id = target.data('id').trim();
    var barcode = target.data('barcode');
    var pname = target.data('pname');
    var brand = target.data('brand');
    var category = target.data('category');
    var description = target.data('description');
    var quantity = target.data('quantity');
    var salesprice = target.data('salesprice');

    editId = id;
    $modalTxtBarCode.val(barcode);
    $modalTxtName.val(pname);
    $modalTxtBrand.val(brand);
    $modalTxtCategory.val(category);
    $modalTxtDescription.val(description);
    $modalTxtSalesPrice.val(salesprice);
    $modalTxtQuantity.val(quantity);
    $modalstockForm.modal('show');
  })

  //onOpenstockForm
  $('#btn-stock-add-new').on('click', function() {
    editId = 0;
    $modalTxtBarCode.val('');
    $modalTxtName.val('');
    $modalTxtBrand.val('');
    $modalTxtCategory.val('');
    $modalTxtDescription.val('');
    $modalTxtSalesPrice.val('');
    $modalTxtQuantity.val('');
    $modalstockForm.modal('show');
  });

  //onSaveButton
  $('#modal-btn-stock-save').on('click', function() {
    //validation
    var isValid = true;

    //barcode
    if ($modalTxtBarCode.val() == '') {
      var $formGroup = $modalTxtBarCode.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtBarCode.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //name
    if ($modalTxtName.val() == '') {
      var $formGroup = $modalTxtName.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtName.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //name
    if ($modalTxtName.val() == '') {
      var $formGroup = $modalTxtName.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtName.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //brand
    if ($modalTxtBrand.val() == '') {
      var $formGroup = $modalTxtBrand.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtBrand.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //category
    if ($modalTxtCategory.val() == '') {
      var $formGroup = $modalTxtCategory.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtCategory.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //description
    if ($modalTxtDescription.val() == '') {
      var $formGroup = $modalTxtDescription.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtDescription.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //sales price
    var reg = new RegExp(/^\d*\.\d{2}$/);
    if ($modalTxtSalesPrice.val() == '' || reg.test($modalTxtSalesPrice.val()) == false) {
      var $formGroup = $modalTxtSalesPrice.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required and only currency!</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtSalesPrice.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //quantity
    var reg = new RegExp(/^\d+$/);
    if ($modalTxtQuantity.val() == '' || reg.test($modalTxtQuantity.val()) == false) {
      var $formGroup = $modalTxtQuantity.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required and only number!</span>');

      isValid = false;
    } else {
      var $formGroup = $modalTxtQuantity.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.addClass('valid');
      $formGroup.removeClass('has-error').addClass('has-success');
    }

    //if valid -> add new or update
    if(isValid)
    {
      if(editId == 0) // insert call
      {
        $.ajax({
          method: "POST",
          url: "insertProcess.php",
          async: false,
          /* Prevent immediate page redirect */
          data: {
            barcode: $modalTxtBarCode.val(),
            pname: $modalTxtName.val(),
            brand: $modalTxtBrand.val(),
            category: $modalTxtCategory.val(),
            description: $modalTxtDescription.val(),
            salesprice: $modalTxtSalesPrice.val(),
            quantity: $modalTxtQuantity.val()
          }

        }).done(function(response) {
          var data = response.trim();
          if(data == 'true')
          {
            $modalstockForm.modal('hide');
            window.location.href = "../Stock/index.php";
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
          url: "updateProcess.php",
          async: false,
          /* Prevent immediate page redirect */
          data: {
            pid: editId,
            barcode: $modalTxtBarCode.val(),
            pname: $modalTxtName.val(),
            brand: $modalTxtBrand.val(),
            category: $modalTxtCategory.val(),
            description: $modalTxtDescription.val(),
            salesprice: $modalTxtSalesPrice.val(),
            quantity: $modalTxtQuantity.val()
          }

        }).done(function(response) {
          var data = response.trim();
          if(data == 'true')
          {
            $modalstockForm.modal('hide');
            window.location.href = "../Stock/index.php";
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
