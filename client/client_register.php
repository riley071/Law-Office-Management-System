<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Client Registration</title>
   <link rel="stylesheet" href="asset/fontawesome/css/all.min.css">
   <link rel="stylesheet" href="asset/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
   <div class="login-box">
      <div class="card card-outline card-primary">
         <div class="card-header text-center">
            <h3>Register as Client</h3>
         </div>
         <div class="card-body">
            <form action="process_register.php" method="post">
               <!-- First Name -->
               <div class="input-group mb-3">
                  <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                  <div class="input-group-append">
                     <div class="input-group-text"><span class="fas fa-user"></span></div>
                  </div>
               </div>

               <!-- Middle Name -->
               <div class="input-group mb-3">
                  <input type="text" class="form-control" name="middle_name" placeholder="Middle Name">
                  <div class="input-group-append">
                     <div class="input-group-text"><span class="fas fa-user"></span></div>
                  </div>
               </div>

               <!-- Last Name -->
               <div class="input-group mb-3">
                  <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                  <div class="input-group-append">
                     <div class="input-group-text"><span class="fas fa-user"></span></div>
                  </div>
               </div>

               <!-- Username -->
               <div class="input-group mb-3">
                  <input type="text" class="form-control" name="username" placeholder="Username" required>
                  <div class="input-group-append">
                     <div class="input-group-text"><span class="fas fa-user-tag"></span></div>
                  </div>
               </div>
<!-- Contact -->
<div class="input-group mb-3">
   <input type="text" class="form-control" name="contact" placeholder="Contact Number" required>
   <div class="input-group-append">
      <div class="input-group-text"><span class="fas fa-phone"></span></div>
   </div>
</div>

               <!-- Email -->
               <div class="input-group mb-3">
                  <input type="email" class="form-control" name="email_address" placeholder="Email" required>
                  <div class="input-group-append">
                     <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                  </div>
               </div>

               <!-- Password -->
               <div class="input-group mb-3">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                  <div class="input-group-append">
                     <div class="input-group-text"><span class="fas fa-lock"></span></div>
                  </div>
               </div>

               <!-- Register Button -->
               <button type="submit" name="register_client" class="btn btn-primary btn-block">Register</button>
            </form>

            <!-- Link to Login Page -->
            <p class="mt-3 mb-0 text-center">
               <a href="client_login.php">Back to Login</a>
            </p>
         </div>
      </div>
   </div>
</body>
</html>
