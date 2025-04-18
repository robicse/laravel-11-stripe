<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laravel Stripe Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container col-md-4">
        <div class="card mt-5">
            <div class="card-header">
                <h4>Make Payment</h4>
            </div>
            <div class="card-body">
                @session('success')
                    <div class="alert alert-success">
                        {{ $value }}
                    </div>
                @endsession

                <div class="p-3 bg-light bg-opacity-10">
                    <h6 class="card-title mb-3">Order Summary</h6>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Sub Total</span>
                        <span>$100.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Shipping</span>
                        <span>$80.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Coupon</span>
                        <span class="text-danger">-$10.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-1 small">
                        <span>Total</span>
                        <strong>$200.00</strong>
                    </div>
                    <form action="{{ route('stripe.post') }}" method="POST" id="stripe-form">
                        @csrf
                        <input type="hidden" name="price" value="200">
                        <input type="hidden" name="stripeToken" id="stripe-token">
                        <div id="card-element" class="form-control"></div>
                        <button class="btn btn-primary w-100 mt-2" type="button" onclick="createToken()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        function createToken(){
            stripe.createToken(cardElement).then(function(result) {
                console.log(result);

                // if (result.error) {
                //     // Display error.message in your UI.
                //     console.log(result.error.message);
                // } else {
                //     console.log(result);
                    if(result.token){
                        document.getElementById('stripe-token').value = result.token.id;
                        document.getElementById('stripe-form').submit();
                    }
                // }
            });
        }
    </script>
</body>
</html>
