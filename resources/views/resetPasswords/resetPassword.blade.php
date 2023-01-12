<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - Sankapo.com</title>
    <link rel="stylesheet" href="./login_form_2.css" />
  </head>
  <body>
    <div class="content">
      <div class="flex-div">
        <div class="name-content">
          <p style="text-decoration: rgb(246, 246, 246)">Sankapo is the largest open marketplace for Zambian buyers and sellers to list their products..</p>
        </div>
        <form action="{{ route('password.reset') }}" method="POST" autocomplete="off">
            @csrf
            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {{ Session::get('fail') }}
                </div>
            @endif
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            <h3 class=" pb-2 pb-md-0 px-md-2">Reset Password</h3> <br>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group mb-3">
                <input type="text" class="form-control" name="email" placeholder="Enter email address"
                    value="{{ $email ?? old('email') }}">
                <span class="text-danger">
                    @error('email')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Enter password"
                    value="{{ old('password') }}">
                <span class="text-danger">
                    @error('password')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="form-group mb-3">
                <input type="password" class="form-control" name="password_confirmation"
                    placeholder="Confirm password" value="{{ old('password_confirmation') }}">
                <span class="text-danger">
                    @error('password_confirmation')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary create-account">Reset password</button>
            </div>
            <br>
            {{-- <a href="{{ route('user.login') }}">Login</a> --}}
        </form>
      </div>
    </div>
  </body>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Poppins", sans-serif;

  background-image:  url("common/resetback.png")
}

.content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.flex-div {
  display: flex;
  justify-content: space-evenly;
  align-items: center;
}

.name-content {
  margin-right: 7rem;
}

.name-content .logo {
  font-size: 3.5rem;
  color: #1877f2;
}

.name-content p {
  font-size: 1.3rem;
  font-weight: 500;
  margin-bottom: 5rem;
}

form {
  display: flex;
  flex-direction: column;
  background: #fff;
  padding: 2rem;
  width: 530px;
  height: 380px;
  border-radius: 0.5rem;
  box-shadow: 0 2px 4px rgb(0 0 0 / 10%), 0 8px 16px rgb(0 0 0 / 10%);
}

form input {
  outline: none;
  padding: 0.8rem 1rem;
  margin-bottom: 0.8rem;
  font-size: 1.1rem;
}

form input:focus {
  border: 1.8px solid #1877f2;
}

form .create-account {
  outline: none;
  border: none;
  background: #06b909;
  padding: 0.8rem 1rem;
  border-radius: 0.4rem;
  font-size: 1.1rem;
  color: #fff;
  width: 75%;
  margin: 0 auto;
}

form .create-account:hover {
  background: #03ad06;
  cursor: pointer;
}

/* //.........Media Query.........// */

@media (max-width: 500px) {
  html {
    font-size: 60%;
  }

  .name-content {
    margin: 0;
    text-align: center;
  }

  form {
    width: 300px;
    height: fit-content;
  }

  form input {
    margin-bottom: 1rem;
    font-size: 1.5rem;
  }


  form .create-account {
    font-size: 1.5rem;
  }

  .flex-div {
    display: flex;
    flex-direction: column;
  }
}

@media (min-width: 501px) and (max-width: 768px) {
  html {
    font-size: 60%;
  }

  .name-content {
    margin: 0;
    text-align: center;
  }

  form {
    width: 300px;
    height: fit-content;
  }

  form input {
    margin-bottom: 1rem;
    font-size: 1.5rem;
  }

  form .create-account {
    font-size: 1.5rem;
  }

  .flex-div {
    display: flex;
    flex-direction: column;
  }
}

@media (min-width: 769px) and (max-width: 1200px) {
  html {
    font-size: 60%;
  }

  .name-content {
    margin: 0;
    text-align: center;
  }

  form {
    width: 300px;
    height: fit-content;
  }

  form input {
    margin-bottom: 1rem;
    font-size: 1.5rem;
  }


  form .create-account {
    font-size: 1.5rem;
  }

  .flex-div {
    display: flex;
    flex-direction: column;
  }

  @media (orientation: landscape) and (max-height: 500px) {
    .header {
      height: 90vmax;
    }
  }  
}

  </style>
</html>
