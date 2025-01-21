<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Order Create Page</title>
</head>

<body>
    <div class="container mt-3" id="main">

        <div class="row">
            <div class="col-sm-8">
                <h1>order create
                    <a href="{{ url('/') }}" class="btn btn-danger" id="home" style="float: right;">Home</a>
                </h1>
            </div>
        </div>

        @if (session('success'))
          <div class="col-sm-8">
            <div class="alert alert-success">
               <p>{{ session('success') }}</p>
            </div>
          </div>
        @endif

        <div class="row">

            <div class="col-sm-8"> <!-- Adjust the column width -->
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center" id="search_section">
                            {{-- search product --}}
                            <div class="col-sm-8">
                                <input type="text" id="search-product" name="string" placeholder="Search product.."
                                    class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#productModal">Browse</button>
                            </div>

                            {{-- search product --}}
                        </div>

                        <!--product Modal start-->
                        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">All Products</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>



                                        <div class="modal-body">
                                            <!-- Input inside modal -->
                                            <input type="text" id="modal-search" name="search"
                                                placeholder="Search here..." class="form-control">

                                            @php
                                                $products = App\Models\Product::get();
                                            @endphp
                                            <!-- Product Table -->
                                            <table class="table" id="product-table">
                                                <!-- Products will be dynamically added here -->
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td><input type="checkbox" value="{{ $product->id }}"
                                                                data-id="{{ $product->id }}" class="product-checkbox">
                                                        </td>
                                                        <td><img src="{{ asset($product->image) }}" width="30"
                                                                height="30" alt=""></td>
                                                        <td>{{ $product->name }}</td>
                                                        <td> TK. {{ $product->price }} </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="add-to-cart"
                                                disabled>Add</button>
                                        </div>

                                </div>
                            </div>
                        </div>

                        <!--product modal end-->

                        {{-- fetch cart product --}}
                        @php
                            $cart_products = App\Models\Cart::where('user_id', Auth::user()->id)->get();
                        @endphp
                        {{-- card product section --}}
                        @if ($cart_products->count() > 0)
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php
                                                $subtotal = 0;
                                            @endphp

                                            @foreach ($cart_products as $cart)
                                                <tr>
                                                    <td>

                                                        <p>
                                                            <img src="{{ asset($cart->product->image) }}" alt=""
                                                                width="30" height="30">

                                                            {{ $cart->product->name }}
                                                        </p>
                                                        <p>

                                                            <span>৳</span> {{ $cart->product->price }}
                                                        </p>

                                                    </td>
                                                    <td>
                                                        <input type="number" min="1"
                                                            value="{{ $cart->quantity }}"data-id="{{ $cart->id }}">
                                                    </td>
                                                    @php
                                                        $subtotal = $subtotal + $cart->product->price * $cart->quantity;
                                                    @endphp
                                                    <td>
                                                        ৳ {{ $cart->product->price * $cart->quantity }}
                                                    </td>
                                                    <td>
                                                        <button class="all_delete_btn" id="delete" data-id="{{ $cart->id }}">X</button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>{{-- row --}}
                        @endif
                        {{-- card product section end --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <p>Payments</p>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-4">
                                <p>Subtotal</p>
                            </div>
                            <div class="col-sm-4">
                                @if ($cart_products->count()>0)
                                <p>{{ $cart_products->count() }} items</p>
                                @else
                                <p>No items</p>
                                @endif

                            </div>
                            <div class="col-sm-4">
                                @if ($cart_products->count()>0)
                                <p>৳ {{ $subtotal }}</p>
                                @else

                                @endif

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <p>Total</p>
                            </div>
                            <div class="col-sm-4">

                            </div>
                            <div class="col-sm-4">


                                    @if ($cart_products->count()>0)
                                    @php
                                        $total = $subtotal;
                                    @endphp
                                    @endif


                                @if ($cart_products->count()>0)
                                <p>৳ {{ $total }}</p>
                                @else

                                @endif
                            </div>
                        </div>



                    </div>

                   <form action="{{ route('order.place') }}" method="POST">
                    @csrf


                    <div class="card-body">

                        @if ($cart_products->count()>0)
                        <span id="due">
                            <input type="checkbox" name="payment_due" value="1"><span>Payment due later</span>
                        </span>
                        @endif

                        @if ($cart_products->count()>0)
                        <input type="hidden" name="total" value="{{ $total }}">
                        <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                        @endif

                        @if ($cart_products->count()>0)
                        <button type="button" id="print_button" onclick="download()" class="btn btn-info">Create Invoice</button>
                        @endif

                        @if ($cart_products->count()>0)
                        <button type="submit" id="order_button" class="btn btn-primary">Place Order</button>
                        @endif
                    </div>
                   </form>


                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    {{-- ajax setup --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        $(document).ready(function() {



            $(document).on('keyup', '#search-product', function(e) {
                e.preventDefault(); // Prevent form submission
                const searchString = $(this).val().trim();
                if (searchString.length > 0) {
                    // Ensure searchString is not empty
                    // Open modal and set search value
                    $('#productModal').modal('show');
                    $('#modal-search').val(searchString); // Set search term in the modal input

                    // Trigger search inside modal
                    fetchProducts(searchString);
                } else {
                    alert('Please enter a search term.');
                }
            });

            // Handle input inside the modal
            $('#modal-search').on('input', function() {
                const searchString = $(this).val();
                fetchProducts(searchString);
            });


            // Fetch products via AJAX
            function fetchProducts(query) {
                $.ajax({
                    url: '/search-products', // Create this route in Laravel
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        const tableBody = $('#product-table tbody');
                        tableBody.empty();
                        if (response.products.length > 0) {
                            response.products.forEach((product) => {
                                tableBody.append(`
                            <tr>
                                <td><input type="checkbox" class="product-checkbox" data-id="${product.id}"></td>
                                <td><img src="{{ asset('/') }}${product.image}" width="30" height="30"></td>
                                <td>${product.name}</td>
                                <td>TK. ${product.price}</td>
                            </tr>
                        `);
                            });
                        } else {
                            tableBody.append(`<tr><td colspan="4">No products found</td></tr>`);
                        }
                        $('#productModal').modal('show');
                    },
                    error: function(xhr) {
                        console.error('Error fetching products:', xhr);
                    },
                });
            }

            // Enable the Add button if any product is selected
            $(document).on('change', '.product-checkbox', function() {
                selectedProducts = $('.product-checkbox:checked').map(function() {
                    return $(this).data('id');
                }).get();

                if (selectedProducts.length > 0) {
                    $('#add-to-cart').prop('disabled', false);
                } else {
                    $('#add-to-cart').prop('disabled', true);
                }
            });


            // Add selected products to the cart
            $('#add-to-cart').on('click', function() {
                const selectedProducts = $('.product-checkbox:checked').map(function() {
                    return $(this).data('id');
                }).get();

                if (selectedProducts.length === 0) {
                    alert('Please select at least one product.');
                    return;
                }

                $.ajax({
                    url: '/add-to-cart',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // CSRF Token
                        products: selectedProducts,
                    },
                    success: function(response) {
                        $('#productModal').modal('hide');
                        window.location.reload();
                        //$('.container').load(location.href+' .container');

                    },
                    error: function(xhr) {
                        console.error('Error adding to cart:', xhr);
                        alert('Failed to add products to cart.');
                    },
                });
            });

            //update product quantity
            $(document).on('change', 'input[type="number"]', function() {
                var quantity = $(this).val(); // Get the new quantity
                var cartId = $(this).data('id'); // Get the cart item ID

                // Send the AJAX request to update the quantity
                $.ajax({
                    url: '{{ route('cart.updateQuantity') }}', // The route for updating the quantity
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                        cart_id: cartId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            //alert('updated quantty');
                            //$('#main').load(location.href+' #main');
                            $('.container').load(location.href+' .container');
                        } else {
                            alert(response.message); // Show an error if the update fails
                        }
                    }
                });
            });

            //delete cart product
            $(document).on('click','#delete',function(){
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ route('cart.deleteProduct') }}', // The route for updating the quantity
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                        id: id,
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.reload();
                            //$('.container').load(location.href+' .container');
                        } else {
                            alert('something went wrong...'); // Show an error if the update fails
                        }
                    }
                });
            });



        });
    </script>

     {{-- hide browser title and date during printing --}}
     <style>
        @page {
            size: auto;
            margin: 0mm;
        }
    </style>
    {{-- hide browser title and date during printing --}}

    <script>
         //create invoice
         function download(){
               $('#print_button').hide();
               $('#order_button').hide();
               $('#search_section').hide();
               $('#home').hide();
               $('#due').hide();
               $('.all_delete_btn').hide();
                window.print();

                $('#print_button').show();
               $('#order_button').show();
               $('#search_section').show();
               $('#home').show();
               $('#due').show();
               $('.all_delete_btn').show();
            }
    </script>
</body>

</html>
