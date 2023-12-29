<div class="row flec">
  <!-- <div class="col-lg-6">

  </div> -->
  <div class="col-lg-6 mt-5">
    <!-- --------------------- start Primary Border with Icons ---------------- -->
    <div class="card">
      <div class="card-body">
        <div class="flec">
          <div class="grid">
            <h5>Ingrese la información de su negocio | empresa</h5>
            <p class="card-subtitle mb-3 flec">
              Cada registro es único por RUC</p>
          </div>
        </div>

        <form class="" method="POST" id="form">
          <input type="hidden" id="login" value="0">
          <div class="form-floating mb-3">
            <input type="text" idata class="form-control border border-primary" placeholder="RUC" id="ruc" value="20552103816">
            <label><i class="ti ti-code me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3">Número RUC</span></label>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input type="email" class="form-control border border-primary" placeholder="Email" id="email">
                <label><i class="ti ti-mail me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3">Correo electrónico</span></label>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input type="phone" class="form-control border border-primary" placeholder="celular" id="telefono">
                <label><i class="ti ti-phone me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3">Número celular</span></label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-6 form-floating mb-3">
              <input type="password" idata class="form-control border border-primary" placeholder="Password" id="password" required>
              <label><i class="ti ti-lock me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3">Password</span></label>
            </div>
            <div class="col-lg-6 form-floating mb-3">
              <input type="password" idata class="form-control border border-primary" placeholder="CPassword" id="cpassword" required>
              <label><i class="ti ti-lock me-2 fs-4 text-primary"></i><span class="border-start border-primary ps-3">Confirm Password</span></label>
            </div>
          </div>

          <div class="d-md-flex align-items-center">
            <div class="form-check mr-sm-2">
              <input type="checkbox" class="form-check-input" id="sf4" value="check">
              <label class="form-check-label" for="sf4">Remember Me</label>
            </div>
            <div class="mt-3 mt-md-0 ms-auto">
              <button type="submit" class="btn btn-primary font-medium rounded-pill px-4" id="postForm">
                <div class="d-flex align-items-center">
                  <i class="ti ti-send me-2 fs-4"></i>
                  Submit
                </div>
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script src="public/helper.js"></script>
<script src="public/shops/js/platform.js?"></script>