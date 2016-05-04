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
    var id = target.data('pid');

    //confirm
    var result = confirm("Are you sure to want to delete the stock ?");
    if (result == true) {
      $.ajax({
        method: "POST",
        url: "/StockController/delete",
        async: false,
        /* Prevent immediate page redirect */
        data: {
          pid: id
        }

      }).done(function(response) {
        var data = response.trim();
        if(data == 'true' || data == 1)
        {
          $modalstockForm.modal('hide');
          window.location.href = "../Stock";
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
    var id = target.data('pid');
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
    if ($modalTxtBarCode.val().trim() == '') {
      var $formGroup = $modalTxtBarCode.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {

      if($modalTxtBarCode.val().trim().length > 10)
      {
        var $formGroup = $modalTxtBarCode.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.removeClass('has-success').addClass('has-error');
        $formGroup.append('<span class="help-block">Just allow 10 characters!</span>');

        isValid = false;
      }
      else {
        var $formGroup = $modalTxtBarCode.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.addClass('valid');
        $formGroup.removeClass('has-error').addClass('has-success');

      }
    }

    //name
    if ($modalTxtName.val().trim() == '') {
      var $formGroup = $modalTxtName.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {

      if($modalTxtName.val().trim().length > 20)
      {
        var $formGroup = $modalTxtName.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.removeClass('has-success').addClass('has-error');
        $formGroup.append('<span class="help-block">Just allow 20 characters !</span>');

        isValid = false;
      }
      else
      {
        var $formGroup = $modalTxtName.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.addClass('valid');
        $formGroup.removeClass('has-error').addClass('has-success');
      }
    }

    //brand
    if ($modalTxtBrand.val().trim() == '') {
      var $formGroup = $modalTxtBrand.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {

      if($modalTxtBrand.val().trim().length > 20)
      {
        var $formGroup = $modalTxtBrand.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.removeClass('has-success').addClass('has-error');
        $formGroup.append('<span class="help-block">Just allow 20 characters !</span>');

        isValid = false;
      }
      else
      {
        var $formGroup = $modalTxtBrand.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.addClass('valid');
        $formGroup.removeClass('has-error').addClass('has-success');
      }
    }

    //category
    if ($modalTxtCategory.val().trim() == '') {
      var $formGroup = $modalTxtCategory.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {

      if($modalTxtCategory.val().trim().length > 20)
      {
        var $formGroup = $modalTxtCategory.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.removeClass('has-success').addClass('has-error');
        $formGroup.append('<span class="help-block">Just allow 20 characters !</span>');

        isValid = false;
      }
      else
      {
        var $formGroup = $modalTxtCategory.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.addClass('valid');
        $formGroup.removeClass('has-error').addClass('has-success');
      }
    }

    //description
    if ($modalTxtDescription.val().trim() == '') {
      var $formGroup = $modalTxtDescription.closest('.form-group');
      $formGroup.find('.help-block').remove();
      $formGroup.removeClass('has-success').addClass('has-error');
      $formGroup.append('<span class="help-block">Required !</span>');

      isValid = false;
    } else {

      if($modalTxtCategory.val().trim().length > 100)
      {
        var $formGroup = $modalTxtDescription.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.removeClass('has-success').addClass('has-error');
        $formGroup.append('<span class="help-block">Just allow 100 characters !</span>');

        isValid = false;
      }
      else
      {
        var $formGroup = $modalTxtDescription.closest('.form-group');
        $formGroup.find('.help-block').remove();
        $formGroup.addClass('valid');
        $formGroup.removeClass('has-error').addClass('has-success');
      }
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
          url: "/StockController/add",
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
          if(data == 'true' || data == 1)
          {
            $modalstockForm.modal('hide');
            window.location.href = "../Stock";
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
          url: "/StockController/update",
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
          if(data == 'true' || data == 1)
          {
            $modalstockForm.modal('hide');
            window.location.href = "../Stock";
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
