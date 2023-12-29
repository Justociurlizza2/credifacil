<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <div class="position-relative overflow-hidden radial-gradient min-vh-100">
    <div class="position-relative z-index-5">
      <div class="row">
        <div id="top-search"></div>
        <div class="col-xl-7 col-xxl-8">
          <!-- <a href="./index.html" class="text-nowrap logo-img d-block px-4 py-9 w-100">
            <img src=public/imgs/dark-logo.svg width="180" alt="">
          </a> -->
          <div class="d-none d-xl-flex align-items-center justify-content-center" style="height: calc(100vh - 10px);">
            <img src=public/assets/images/backgrounds/credit-card-login.jpg alt="" class="img-fluid" width="800">
          </div>
        </div>

        <div class="col-xl-5 col-xxl-4">
          <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4 pt-0">
            <div class="col-sm-8 col-md-6 col-xl-9">
              <h2 class="mb-3 fs-7 fw-bolder">Bienvenido a CrediFacil</h2>
              <p class=" mb-9">Tu brillante Asistente para facturas</p>
              <!-- Face & Google -->
              <!-- <div class="row">
                <div class="col-6 mb-2 mb-sm-0">
                  <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                    <img src=public/imgs/google-icon.svg alt="" class="img-fluid me-2" width="18" height="18">
                    <span class="d-none d-sm-block me-1 flex-shrink-0">Sign in with</span>Google
                  </a>
                </div>
                <div class="col-6">
                  <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="javascript:void(0)" role="button">
                    <img src=public/imgs/facebook-icon.svg alt="" class="img-fluid me-2" width="18" height="18">
                    <span class="d-none d-sm-block me-1 flex-shrink-0">Sign in with</span>FB
                  </a>
                </div>
              </div> -->
              <div class="position-relative text-center my-4">
                <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">or sign in with</p>
                <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
              </div>

              <form class="" method="POST" id="form">
                <input type="hidden" id="login" value="1">
                <div class="mb-3">
                  <label for="usuario" class="form-label">Usuario</label>
                  <input type="text" idata class="form-control" id="usuario" aria-describedby="emailHelp" value="justo">
                </div>
                <div class="mb-4">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" idata class="form-control" id="password" value="1526">
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="form-check">
                    <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label text-dark" for="flexCheckChecked">
                      Remeber this Device
                    </label>
                  </div>
                  <a class="text-primary fw-medium" href="./authentication-forgot-password.html">Forgot Password ?</a>
                </div>
                <!-- <a href="login#" type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In -->
                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2" id="postForm">Ingresar</button>

                <div class="popup" role="alert" id="hide">
                  <button class="flej btn-close"><i class="mdi mdi-close"></i></button>
                  <div class="d-flex align-items-center font-medium me-3 me-md-0">
                    <i class="ti ti-info-circle fs-5 me-2 text-success"></i>
                    <span>A simple success outline alert</span>
                  </div>
                </div>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!-- Custom Dependencies -->
<!-- <script>var exports = {};</script> -->
<!-- <script type="module" src="./dist/User.js"></script> -->
<script src="public/js/Helpers/Global.js"></script>
<script src="public/js/Helpers/Helper.js"></script>
<script src="public/js/Utils/Utils.js"></script>
<script type="module" src="public/shop/js/platform.js?v=<?php echo(date("His")) ?>"></script>