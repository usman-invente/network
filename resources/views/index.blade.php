<!doctype html>
<html lang="en">

<head>
    <title>{{ env('APP_NAME') }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="color-scheme" content="light dark">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css') }}">
    <script>
        var APP_URL = '{{ url('/') }}';
        var CSRF_TOKEN = '{{ csrf_token() }}';
    </script>
</head>

<body>
    <div class="bg-img-start d-flex aligns-items-center">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="col-md-12 col-12 text-center">
                <h1 class="display-1" style="font-weight:300;">{{ env('APP_NAME') }}</h1>
            </div>
        </div>
    </div>
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h3 class="mb-4">If you no longer wish to receive faxes from Health Network One or its affiliates, please enter your fax number below.</h3>
                <h6 class="mb-5">Si no desea recibir comunicaciones promocionales de parte de Health Network One o sus afiliadas, ingrese su n��mero de fax.</h6>
                <p class="alert alert-success d-none">
                    <strong>Success!</strong> Your fax number will be removed from all other future fax advertisements.
                </p>
                <p class="alert alert-danger d-none">
                    <strong>Warning!</strong> Please select an option.
                </p>
                
            </div>
        </div>
    </section>
    <form class="needs-validation mb-5" novalidate>
        <section class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-md-4">
                    
                        <label for="ufax" class="form-label">Fax number </label>
                        <input type="tel" class="form-control" id="ufax">
                        <div class="invalid-feedback">
                            Please enter your fax number.
                        </div>
                    
                </div>
            </div>
            
            <div class="row justify-content-center mt-5">
                <div class="col-md-4">
                    <button class="w-100 btn btn-primary btn-lg btn-submit" type="submit">
                        Opt Out
                        <div class="spinner-border d-none" role="status"></div>
                    </button>
                </div>
            </div>

        </section>
    </form>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery-input-mask-phone-number.min.js') }}"></script>

    <script>
        $(document).ready(function () {
                $('#ufax').usPhoneFormat({
                    format: '(xxx) xxx-xxxx',
                });
            });
    </script>
    
    
</body>

</html>
