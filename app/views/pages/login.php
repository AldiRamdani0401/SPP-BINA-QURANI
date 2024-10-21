<div id="login-image" class="align-items-center justify-content-center d-none d-sm-flex"
  style="background:#626F47;width:60%;">
  <img src="./assets/images/logo.png" height="200" alt="logo bina qur'ani karawang" class="me-2">
  <div id="logo-text">
    <h1 class="text-white mb-0">Portal Web SPP</h1>
    <p class="text-white mb-0" style="font-size:26px;">Bina Qur'ani Karawang</p>
  </div>
</div>
<div class="card align-self-center flex-grow-1 px-5 py-4 rounded-0" style="height: 100%;">
  <form method="POST" action="/login" class="d-flex flex-column justify-content-center my-auto">
    <h1 class="m-0">Log In</h1>
    <hr style="height: 3px; background-color:#557C56; border: none; border-radius:5px;">
    <div class="form-group mb-3">
      <label for="email" class="mb-1">Email address</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="please enter your email">
    </div>
    <div class="form-group mb-4">
      <label for="password" class="mb-1">Password</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary p-2 fw-bold">Login</button>
  </form>
</div>