<!DOCTYPE html>
<html>
    <head>
        <title>Scholarly Registration</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="Public/css/Styles.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-fluid p-0 position-relative">
            <img src="https://www.studiesup.com/wp-content/uploads/import/UL_Glucksman-Library-1-scaled.jpg" style="float:left; min-height:850px; height:100vh">

            <div style="background-color:white; width:40vw; min-width:500px; min-height:850px;height:100vh; right:0;" class="justify-content-center position-absolute">
                <div class="d-flex justify-content-center" style="margin-top:10vh;">
                    <div class="form-signin">
                        <img src="Public/Images/scholarly logo.png" style="height:5rem; width:auto;">
                        
                        <h1 class="pt-5 pb-4">Register</h1>

                        <form method="POST" action="?controller=auth&action=register">
                            <div class="form-floating mb-4">
                                <input name="RegisterEmail" id="emailInput" type="email" class="form-control" placeholder="name@ul.ie">
                                
                                <label for="emailInput">UL email address</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input name="RegisterFirstName" id="firstNameInput" class="form-control" placeholder="Name">
                                
                                <label for="firstNameInput">Name</label>
                            </div>
                            
                            <div class="form-floating mb-4">
                                <input name="RegisterLastName" id="lastNameInput" class="form-control" placeholder="Surname">
                                
                                <label for="lastNameInput">Surname</label>
                            </div>

                            <div class="form-floating mb-4">
                                <input name="RegisterPassword" id="passwordInput" type="password" class="form-control" placeholder="Password">
                                
                                <label for="passwordInput">Password</label>
                            </div>
                            
                            <div class="form-floating mb-4">
                                <input name="RegisterConfirmPassword" id="confirmPasswordInput" type="password" class="form-control" placeholder="Password">

                                <label for="confirmPasswordInput">Confirm password</label>
                            </div>
                            
                            <div class="pt-4">
                                <button class="position-relative start-50 translate-middle btn" type="submit">Submit</button>
                            </div>
                        </form>
                        
                        <div class="pt-4" style="text-align:center;">
                            Already have an account? Click <a href="?controller=auth&action=loginView">here</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
