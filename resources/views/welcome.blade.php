<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <meta name="csrf-token" content="{{ csrf_token() }}" />  
    </head>
      <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Navbar</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
                <form class="d-flex" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
              </div>
            </div>
        </nav>

        <div class="container mt-5">
            <form>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="product_name" name="product_name">
                  <div id="product_name_error" class="form-text"></div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Quantity in stock</label>
                  <input type="text" class="form-control" id="quantity" name="quantity">
                  <div id="quantity_error" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Price per item</label>
                    <input type="text" class="form-control" id="price" name="price">
                    <div id="price_error" class="form-text"></div>
                  </div>
                <button type="button" class="btn btn-primary btn-submit">Submit</button>
              </form>

              <table class="table mt-5" id="productTable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                  </tr>
                </thead>
                <tbody>
                 
                </tbody>
              </table>

        </div>
      </body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function resetFields()
        {
            $("#product_name").val('').removeClass('is-invalid');
            $("#quantity").val('').removeClass('is-invalid');
            $("#price").val('').removeClass('is-invalid');
        }

        $(".btn-submit").click(function(e){
            e.preventDefault();
            var product_name = $("#product_name").val();
            var quantity = $("#quantity").val();
            var price = $("#price").val();

            $.ajax({
            type:'POST',
            url:"{{ route('products.store') }}",

            data:{name:product_name, quantity:quantity, price:price},

            success:function(data){
                console.log(data);

                if($.isEmptyObject(data.error)){
                    resetFields();
                    $('#productTable tbody').append(`
                        <tr>
                             <td>${data.product.id}</td>
                            <td>${data.product.name}</td>
                            <td>${data.product.name}</td>
                            <td>${data.product.quantity}</td>
                        </tr>
                    `);
                }
                alert('product created!!!');

            },
            error: function (xhr) {
                console.log(xhr.responseJSON)
                // Show validation errors
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.name) {
                        $('#product_name').addClass('is-invalid')
                        $('#product_name_error').text(errors.name[0]).addClass('invalid-feedback');;
                    }
                    if (errors.price) {
                        $('#price').addClass('is-invalid')
                        $('#price_error').text(errors.price[0]).addClass('invalid-feedback');;
                    }
                    if (errors.quantity) {
                        $('#quantity').addClass('is-invalid')
                        $('#quantity_error').text(errors.quantity[0]).addClass('invalid-feedback');
                    }

                }
            }

        });



});

        </script>

</html>
