<!DOCTYPE html>
<html>
    <head>
        <title>Scholarly Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../public/css/Styles.css" rel="stylesheet">
    </head>

    <body style="overflow:hidden;">
        <div class="container-fluid p-0 position-relative">
            <img src="https://www.studiesup.com/wp-content/uploads/import/UL_Glucksman-Library-1-scaled.jpg" style="margin-top:-300px; float:right;">
            <div style="top:20vh; right:10vw;"  class="d-flex justify-content-center position-absolute">
                <div class="form-signin pt-3 pb-4 px-5" style="background-color:white; border-radius:5%; box-shadow: 0.25rem 0.25rem 0.25rem;">
                    <img src="https://github.com/kylehellstrom-22343261/Scholarly/blob/main/App/scholarly%20logo.png?raw=true" style="height: 40pt; width:auto;">
                    <h1 class="py-3">Register</h1>
                    <div class="form-floating mb-3">
                        <input id="emailInput" type="email" class="form-control" placeholder="name@ul.ie">
                        <label for="emailInput">UL email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input id="passwordInput" type="password" class="form-control" placeholder="Password">
                        <label for="passwordInput">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input id="confirmPasswordInput" type="password" class="form-control" placeholder="Password">
                        <label for="confirmPasswordInput">Confirm password</label>
                    </div>
                    <div class="pt-3">
                        <button class="position-relative start-50 translate-middle btn" type="submit">Submit</button>
                    </div>
                    <div class="pt-2">
                        Already have an account? Click <a href="?controller=auth&action=login">here</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
