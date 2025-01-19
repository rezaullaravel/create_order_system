<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Home Page</title>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-3">
                <ul class="list-group">
                    <li class="list-group-item"><a href="{{ url('/') }}" class="btn btn-secondary">Back To Side</a>
                    </li>
                    <li class="list-group-item"><a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                    </li>
                    <li class="list-group-item"><a href="{{ route('order.list') }}" class="btn btn-info">Order</a></li>
                    <li class="list-group-item"><a href="{{ route('logout') }}" class="btn btn-danger">Logout</a></li>

                </ul>
            </div>

            <div class="col-sm-9">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Customer</th>
                                    <th>Order Total</th>
                                    <th>Order Subtotal</th>
                                    <th>Payment Due</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $key => $order)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->total }} TK.</td>
                                        <td>{{ $order->subtotal }} TK.</td>
                                        <td>
                                            @if ($order->payment_due == '1')
                                                <span>Yes</span>
                                            @else
                                            <span>No</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ date('d-m-Y',strtotime($order->created_at)) }}
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-primary btn-sm">View Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>


</body>

</html>
