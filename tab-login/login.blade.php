
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/official-logo-cropped.png') }}" type="image/png">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('assets/tab-login/login-style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

<style>
    body {
        background-image: url('{{ asset('assets/img/login-bg.png') }}');
        background-repeat: no-repeat;
        background-size: cover;

    }
</style>

</head>

<body>

    <section class="myform-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-area login-form">
                        <div class="form-content">
                            
                            <div class="d-flex flex-column align-items-center">
                                <h2>Automated Support Activity System</h2>
                                <p>Note: Please use your Azure AD to login</p>

                                <a class="btn-login" href="{{ route('azure-auth') }}" role="button" style="width:75%;">Login</a>

                            </div>

                        </div>

                        <div class="form-input">
                            <img src="{{ asset('assets/img/official-logo.png') }}" alt="logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
