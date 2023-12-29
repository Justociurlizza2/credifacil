<head>
    <link rel="stylesheet" type="text/css"
        href="public/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
</head>
<div class="body-wrapper">
    <div class="container-fluid pmob-15">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Cuotas (por cobrar)</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="main">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Cuotas</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="public/assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="checkout">
            <div class="card shadow-none border">
                <div class="card-body p-4 pmob-0">
                    <div class="row" id="renderDiv" style="display:none">
                        <div id="render" class="row">

                            <!-- <div class="col-lg-4 d-flex align-items-strech">
                                <div class="card text-bg-primary border-0 w-100">
                                    <div class="card-body pb-0 p-3">
                                        <h5 class="fw-semibold mb-1 text-white card-title">s/ 117.50</h5>
                                        <p class="fs-3 mb-3 text-white">Justo Ciurlizza</p>
                                        <div class="text-center mt-0">
                                            <img src="public/assets/images/backgrounds/piggy.png" class="img-fluid" alt="">
                                            <span class="badge text-bg-light fs-2 rounded-4 lh-sm mt-3 me-9 py-1 px-2 fw-semibold position-absolute top-0 end-0">
                                                pendiente
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card mx-2 mb-2 mt-n2">
                                        <div class="card-body p-3">
                                            <div class="mb-4 pb-1">
                                                <div class="d-flex justify-content-between align-items-center mb-6">
                                                    <div>
                                                        <h6 class="mb-1 fs-4 fw-semibold">Deuda s/ <span txt="monto">250.00</span></h6>
                                                        <p class="fs-3 mb-0"><span>Pagando s/ </span>117.50</p>
                                                    </div>
                                                    <div class="grid">
                                                        <span class="badge bg-primary-subtle text-primary fw-semibold fs-3">
                                                            <span class="avance">55</span><span>%</span>
                                                        </span>
                                                        <span class="fs-2">avance %</span>
                                                    </div>
                                                </div>
                                                <div class="progress bg-primary-subtle" style="height: 4px">
                                                    <div class="progress-bar w-50" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="justify-content-center w-100 btn mb-1 bg-success-subtle text-success font-medium d-flex align-items-center">
                                                    <i class="ti ti-coin fs-6 me-2"></i>
                                                    Cobrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                        </div>
                        <div class="pagenumbers" id="pagination"></div>
                    </div>
                    <div class="wizard-content" id="renderform" style="display:none">
                        <form action="#" class="tab-wizard wizard-circle" id="form">
                            <input type="hidden" id="id" idata value="0">
                            <input type="hidden" id="idc" idata>
                            <!-- Step 1 -->
                            <h6>Cart</h6>
                            <section>
                                <!------------- < Clients> ------------->
                                <div class="fleb">
                                    <h4 class="mt-1 mb-1 text-white">Cliente</h4>

                                    <ul class="mb-0 list-inline text-light">
                                        <li class="list-inline-item me-3 flex">
                                            <p class="mb-0 font-13 text-white-50">Nos consumió: s/ &nbsp</p>
                                            <h5 class="mb-1" id="compras"> 0.</h5>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="app-search dropdown col-lg-8 flex">
                                        <div class="col-lg-6 col-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control dropdown-toggle"
                                                    placeholder="Nombre cliente ..." id="cliente" value=""
                                                    autocomplete="off">
                                                <span class="mdi mdi-account-plus-outline search-icon"
                                                    id="newClient"></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-4">
                                            <div class="input-group irfc">
                                                <input class='form-control bg-success sp-in text-white p-2' type='text'
                                                    placeholder='N° documento'
                                                    pattern="[a-zA-Z]{4,4}[0-9]{6}[0-9a-zA-Z]{3}"
                                                    onkeyup="validateJSA(event, 'rfc')" value="" ; name='numero'
                                                    id="numero" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="person_dropdown"
                                        onmouseleave="this.classList.remove('d-block')"
                                        style="overflow:scroll;max-height:400px;width:400px">
                                        <div class="dropdown-header noti-title">
                                            <h5 class="text-overflow mb-2">Found <span class="text-danger"
                                                    id="conteo">1</span> results</h5>
                                        </div>
                                        <div class="notification-list" id="persons_list"></div>
                                    </div>
                                </div>
                                <!------------- </Clients> ------------->

                                <!------------- < Credito> ------------->
                                <div class="flex">
                                    <span style="color:rebeccapurple;font-weight:700">Crédito</span>
                                    <p class="font-10 m-0 mt-2">Capital</p>
                                </div>
                                <div class="col-lg-4 col-xs-12">
                                    <div class="input-group">
                                        <button class="btn bg-success-subtle text-info font-medium"
                                            type="button">s/</button>
                                        <input type="number" class="form-control fs-4 p-0 px-3" min="100.00"
                                            id="credito" idata value="200.00">
                                        <button class="btn bg-info-subtle text-info font-medium"
                                            type="button">Go!</button>
                                    </div>
                                </div>
                                <!------------- < Tasa> ------------->
                                <div class="flex col-12">
                                    <div class="col-lg-4 col-6">
                                        <div class="flex">
                                            <span style="color:rebeccapurple;font-weight:700">Tasa</span>
                                            <p class="font-10 m-0 mt-2">porcentaje</p>
                                        </div>
                                        <div class="input-group mb-3">
                                            <button class="btn bg-info-subtle text-info font-medium"
                                                type="button">%</button>
                                            <input type="number" class="form-control" id="tasa" idata value="5"
                                                placeholder="" aria-label="" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <div class="flex">
                                            <span style="color:rebeccapurple;font-weight:700">Tipo</span>
                                            <p class="font-10 m-0 mt-2">período</p>
                                        </div>
                                        <select class="form-select mb-3" type="number" id="tipo" idata>
                                            <option value="1">Tasa diaria</option>
                                            <option value="15">Tasa quincenal</option>
                                            <option value="30">Tasa mensual</option>
                                            <option value="360">Tasa anual</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="flex col-12">
                                    <div class="col-lg-4 col-6">
                                        <div class="flex">
                                            <span style="color:rebeccapurple;font-weight:700">Lapsos</span>
                                            <p class="font-10 m-0 mt-2">cantidad</p>
                                        </div>
                                        <div class="input-group mb-3">
                                            <button class="btn bg-info-subtle text-info font-medium"
                                                type="button">n°</button>
                                            <input type="number" value=7 min="1" class="form-control" id="nlapsos" time
                                                placeholder="" aria-label="" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <div class="flex">
                                            <span style="color:rebeccapurple;font-weight:700">Lapso</span>
                                            <p class="font-10 m-0 mt-2">tipo</p>
                                        </div>
                                        <select class="form-select mb-3" id="lapsos" time>
                                            <option value="1">Días</option>
                                            <option value="7">Semanas</option>
                                            <option value="15">Quincenas</option>
                                            <option value="30">Meses</option>
                                            <option value="360">Años</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-4 col-6">
                                        <div class="flex">
                                            <span style="color:rebeccapurple;font-weight:700">Período</span>
                                            <p class="font-10 m-0 mt-2">pago</p>
                                        </div>
                                        <select class="form-select mb-3" type="number" id="periodo" idata>
                                            <option value="1">Pagará diario</option>
                                            <option value="2">Dejando un día</option>
                                            <option value="7">Semanal</option>
                                            <option value="15">Quincenal</option>
                                            <option value="30">Mensual</option>
                                        </select>
                                    </div>
                                </div>
                                <!------------- </Tasa> ------------->
                                <div class="flex col-12">
                                    <div class="inbox-item flec mb-mob-20 col-lg-4 col-12">
                                        <div class="d-flex pr-2">
                                            <i class="uil uil-schedule font-18 text-success me-1"></i>
                                            <div>
                                                <h5 class="mt-1 font-14 text-white">Fecha</h5>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="inicio" idata
                                                placeholder="dd/mm/yyyy" />
                                            <span class="input-group-text">
                                                <i class="ti ti-calendar fs-5"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-5 mb-1">
                                        <div class="flex">
                                            <span style="color:rebeccapurple;font-weight:700">Plazo (días)</span>
                                        </div>
                                        <div class="input-group mb-3">
                                            <button class="btn bg-info-subtle text-info font-medium"
                                                type="button">n°</button>
                                            <input type="number" value="7" class="form-control" id="plazo" idata
                                                placeholder="autocalculable" aria-label=""
                                                aria-describedby="basic-addon1" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-7 mt-1">
                                        <button type="button" id="buttonCuota"
                                            class="justify-content-center w-100 btn mb-1 btn-rounded bg-primary-subtle text-primary font-medium d-flex align-items-center">
                                            <i class="mdi mdi-cash fs-7 me-2"></i>
                                            Calcular CUOTA
                                        </button>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-4 flej">
                                    <div class="col-lg-4 col-12">
                                        <button
                                            class="btn mb-1 d-block w-100 btn-outline-success waves-effect waves-light p-2"
                                            type="button" style="line-height:25px" id="buttonCredito">
                                            <i class="mdi mdi-account-cash fs-7 me-2"
                                                style="vertical-align:text-top"></i>
                                            <span>New Crédito</span>
                                        </button>
                                    </div>
                                </div>
                                <!------------- </Credito> ------------->
                                <div class="order-summary border rounded p-4 my-4" id="cuotaDetalle">
                                    <div class="p-3">
                                        <h5 class="fs-5 fw-semibold mb-4">Cuota Detalle</h5>
                                        <div class="d-flex justify-content-between mb-0">
                                            <p class="mb-0 fs-4">Cuota</p>
                                            <div class="flex">
                                                <h4 class="text-dark">s/ &nbsp;</h4>
                                                <h6 class="mb-0 fs-6 fw-semibold text-primary" txt="cuota">100.99</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="mb-0 fs-4">Última Cuota</p>
                                            <h6 class="mb-0 fs-4 fw-semibold text-danger" txt="ultimaQ">0.99</h6>
                                        </div>
                                        <div class="d-flex justify-content-between mb-4">
                                            <p class="mb-0 fs-4">Residuo</p>
                                            <h6 class="mb-0 fs-4 fw-semibold text-success" txt="residuo">+0.00</h6>
                                        </div>
                                        <div class="d-flex justify-content-between mb-0">
                                            <p class="mb-0 fs-4">Monto</p>
                                            <div class="flex">
                                                <h4 class="text-primary">s/ &nbsp;</h4>
                                                <h6 class="mb-0 fs-4 fw-semibold" txt="monto">100.99</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <p class="mb-0 fs-4">Confirmado</p>
                                            <div class="flex">
                                                <h4 class="text-primary">s/ &nbsp;</h4>
                                                <h6 class="mb-0 fs-4 fw-semibold" txt="confirm">100.99</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0 fs-4 fw-semibold">Cuotas</h6>
                                            <div class="flex">
                                                <h6 class="mb-0 fs-5 fw-semibold" txt="cuotas">7?</h6>
                                                <h4 class="fs-3 text-primary">&nbsp; q</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 2 -->
                            <h6>Billing & address</h6>
                            <section>
                                <div class="billing-address-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="card shadow-none border">
                                                <div class="card-body p-4">
                                                    <h6 class="mb-3 fs-4 fw-semibold">Johnathan Doe</h6>
                                                    <p class="mb-1 fs-2">E601 Vrundavan Heights, godrej
                                                        garden city - 382481</p>
                                                    <h6 class="d-flex align-items-center gap-2 my-4 fw-semibold fs-4">
                                                        <i class="ti ti-device-mobile fs-7"></i>9999501050
                                                    </h6>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-primary  billing-address">Deliver
                                                        To
                                                        this address</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card shadow-none border">
                                                <div class="card-body p-4">
                                                    <h6 class="mb-3 fs-4 fw-semibold">ParleG Doe</h6>
                                                    <p class="mb-1 fs-2">D201 Galexy Heights, godrej garden
                                                        city - 382481</p>
                                                    <h6 class="d-flex align-items-center gap-2 my-4 fw-semibold fs-4">
                                                        <i class="ti ti-device-mobile fs-7"></i>9999501050
                                                    </h6>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-primary  billing-address">Deliver
                                                        To
                                                        this address</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card shadow-none border">
                                                <div class="card-body p-4">
                                                    <h6 class="mb-3 fs-4 fw-semibold">Guddu Bhaiya</h6>
                                                    <p class="mb-1 fs-2">Mumbai khao gali, Behind shukan,
                                                        godrej garden city - 382481</p>
                                                    <h6 class="d-flex align-items-center gap-2 my-4 fw-semibold fs-4">
                                                        <i class="ti ti-device-mobile fs-7"></i>9999501050
                                                    </h6>
                                                    <a href="javascript:void(0)"
                                                        class="btn btn-outline-primary  billing-address">Deliver
                                                        To
                                                        this address</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-summary border rounded p-4 my-4">
                                        <div class="p-3">
                                            <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-0 fs-4">Sub Total</p>
                                                <h6 class="mb-0 fs-4 fw-semibold">s/ 285.20</h6>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-0 fs-4">Discount 5%</p>
                                                <h6 class="mb-0 fs-4 fw-semibold text-danger">-$14</h6>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-0 fs-4">Shipping</p>
                                                <h6 class="mb-0 fs-4 fw-semibold">Free</h6>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0 fs-4 fw-semibold">Total</h6>
                                                <h6 class="mb-0 fs-5 fw-semibold">$271</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="payment-method-list payment-method">
                                    <div class="delivery-option btn-group-active  card shadow-none border">
                                        <div class="card-body p-4">
                                            <h6 class="mb-3 fw-semibold fs-4">Delivery Option</h6>
                                            <div class="btn-group row w-100" role="group"
                                                aria-label="Basic radio toggle button group">
                                                <div class="position-relative col-lg-6">
                                                    <input type="radio"
                                                        class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative"
                                                        name="deliveryOpt1" id="btnradio1" autocomplete="off" checked>
                                                    <label class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100"
                                                        for="btnradio1">
                                                        <div class="text-start ps-2">
                                                            <h6 class="fs-4 fw-semibold mb-0">Free delivery
                                                            </h6>
                                                            <p class="mb-0 text-muted">Delivered on Firday,
                                                                May 10</p>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="position-relative col-lg-6">
                                                    <input type="radio"
                                                        class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative"
                                                        name="deliveryOpt1" id="btnradio2" autocomplete="off">
                                                    <label class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100"
                                                        for="btnradio2">
                                                        <div class="text-start ps-2">
                                                            <h6 class="fs-4 fw-semibold mb-0">Fast delivery
                                                                ($2,00)</h6>
                                                            <p class="mb-0 text-muted">Delivered on
                                                                Wednesday, May 8</p>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="payment-option btn-group-active  card shadow-none border">
                                        <div class="card-body p-4">
                                            <h6 class="mb-3 fw-semibold fs-4">Payment Option</h6>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="btn-group row" role="group"
                                                        aria-label="Basic radio toggle button group">
                                                        <div class="position-relative col-12 mb-3">
                                                            <input type="radio"
                                                                class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative"
                                                                name="paymentType1" id="btnradio3" autocomplete="off"
                                                                checked>
                                                            <label
                                                                class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100"
                                                                for="btnradio3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="text-start ps-2">
                                                                        <h6 class="fs-4 fw-semibold mb-0">
                                                                            Pay with Paypal</h6>
                                                                        <p class="mb-0 text-muted">You will
                                                                            be redirected to PayPal website
                                                                            to
                                                                            complete your purchase securely.
                                                                        </p>
                                                                    </div>
                                                                    <img src=public/assets/images/svgs/paypal.svg alt=""
                                                                        class="img-fluid ms-auto">
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="position-relative col-12 mb-3">
                                                            <input type="radio"
                                                                class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative"
                                                                name="paymentType1" id="btnradio4" autocomplete="off">
                                                            <label
                                                                class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100"
                                                                for="btnradio4">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="text-start ps-2">
                                                                        <h6 class="fs-4 fw-semibold mb-0">
                                                                            Credit / Debit Card</h6>
                                                                        <p class="mb-0 text-muted">We
                                                                            support Mastercard, Visa,
                                                                            Discover and Stripe.
                                                                        </p>
                                                                    </div>
                                                                    <img src="public/assets/images/svgs/mastercard.svg"
                                                                        alt="" class="img-fluid ms-auto">
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="position-relative col-12">
                                                            <input type="radio"
                                                                class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative"
                                                                name="paymentType1" id="btnradio5" autocomplete="off">
                                                            <label
                                                                class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100"
                                                                for="btnradio5">
                                                                <div class="text-start ps-2">
                                                                    <h6 class="fs-4 fw-semibold mb-0">Cash
                                                                        on Delivery</h6>
                                                                    <p class="mb-0 text-muted">Pay with cash
                                                                        when your order is delivered.</p>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <img src=public/assets/images/products/payment.svg alt=""
                                                        class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-summary border rounded p-4 my-4">
                                        <div class="p-3">
                                            <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-0 fs-4">Sub Total</p>
                                                <h6 class="mb-0 fs-4 fw-semibold">s/ 285.20</h6>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-0 fs-4">Discount 5%</p>
                                                <h6 class="mb-0 fs-4 fw-semibold text-danger">-$14</h6>
                                            </div>
                                            <div class="d-flex justify-content-between mb-4">
                                                <p class="mb-0 fs-4">Shipping</p>
                                                <h6 class="mb-0 fs-4 fw-semibold">Free</h6>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-0 fs-4 fw-semibold">Total</h6>
                                                <h6 class="mb-0 fs-5 fw-semibold">$271</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- Step 3 -->
                            <h6>Payment</h6>
                            <section class="payment-method text-center">
                                <h5 class="fw-semibold fs-5">Thank you for your purchase!</h5>
                                <h6 class="fw-semibold text-primary mb-7">Your order id:
                                    3fa7-69e1-79b4-dbe0d35f5f5d</h6>
                                <img src="public/assets/images/products/payment-complete.jpg" alt=""
                                    class="img-fluid mb-4" width="300">
                                <p class="mb-0 fs-2">We will send you a notification<br>within 2 days when
                                    it ships.</p>
                                <div class="d-sm-flex align-items-center justify-content-between my-4">
                                    <a href="./eco-checkout.html" class="btn btn-success d-block mb-2 mb-sm-0">Continue
                                        Shopping</a>
                                    <a href="javascript:void(0)" class="btn btn-primary d-block">Download
                                        Receipt</a>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #list .foto img {
        width: 100%;
        height: 125px;
        transition: .6s ease-in-out
    }

    /* .card-title {
        background: #00000075;
        transform: translate(0, -50px)
    } */

    .title {
        color: #fff !important;
        text-align: center !important;
        line-height: 50px
    }

    .product-container {
        transform: translate(0, -50px)
    }

    .universal-card {
        background: indigo;
        height: 200px;
        cursor: pointer
    }

    /* New client */
    #newClient {
        background: #11a44b;
        color: aliceblue;
        height: 38px;
        width: 38px;
        left: 1px;
        text-align: center;
        cursor: pointer;
    }

    #newClient:hover {
        background: aliceblue;
        color: #11a44b;
        border: 1px solid #11a44b;
        transition: .6s;
    }
</style>

<!-- JS dependencies -->
<script type="module" src="dist/Models/Cuota.js?v=<?php echo rand(0,139);?>"></script>
<script type="module" src="dist/Views/CuotaView.js"></script>
<script type="module" src="dist/Services/Cuotas.js"></script>

<!-- Custom JS dependencies -->
<script src="public/assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
<script src="public/assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="public/assets/js/forms/form-wizard.js"></script>
<script src="public/assets/js/apps/ecommerce.js"></script>
<script src="public/assets/libs/moment-js/moment.js"></script>
<script src="public/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="public/assets/libs/bootstrap-datepicker/dist/js/datepicker-init.js"></script>

<!-- <div class="datepicker datepicker-dropdown dropdown-menu datepicker-orient-left datepicker-orient-bottom" style="top: 483.562px; left: 324px; z-index: 10; display: block;"><div class="datepicker-days" style=""><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">December 2023</th><th class="next">»</th></tr><tr><th class="dow">Su</th><th class="dow">Mo</th><th class="dow">Tu</th><th class="dow">We</th><th class="dow">Th</th><th class="dow">Fr</th><th class="dow">Sa</th></tr></thead><tbody><tr><td class="old day" data-date="1700956800000">26</td><td class="old day" data-date="1701043200000">27</td><td class="old day" data-date="1701129600000">28</td><td class="old day" data-date="1701216000000">29</td><td class="old day" data-date="1701302400000">30</td><td class="day" data-date="1701388800000">1</td><td class="day" data-date="1701475200000">2</td></tr><tr><td class="day" data-date="1701561600000">3</td><td class="day" data-date="1701648000000">4</td><td class="day" data-date="1701734400000">5</td><td class="day" data-date="1701820800000">6</td><td class="day" data-date="1701907200000">7</td><td class="day" data-date="1701993600000">8</td><td class="day" data-date="1702080000000">9</td></tr><tr><td class="day" data-date="1702166400000">10</td><td class="day" data-date="1702252800000">11</td><td class="day" data-date="1702339200000">12</td><td class="day" data-date="1702425600000">13</td><td class="day" data-date="1702512000000">14</td><td class="today day" data-date="1702598400000">15</td><td class="day" data-date="1702684800000">16</td></tr><tr><td class="day" data-date="1702771200000">17</td><td class="day" data-date="1702857600000">18</td><td class="day" data-date="1702944000000">19</td><td class="day" data-date="1703030400000">20</td><td class="day" data-date="1703116800000">21</td><td class="day" data-date="1703203200000">22</td><td class="day" data-date="1703289600000">23</td></tr><tr><td class="day" data-date="1703376000000">24</td><td class="day" data-date="1703462400000">25</td><td class="day" data-date="1703548800000">26</td><td class="day" data-date="1703635200000">27</td><td class="day" data-date="1703721600000">28</td><td class="day" data-date="1703808000000">29</td><td class="day" data-date="1703894400000">30</td></tr><tr><td class="day" data-date="1703980800000">31</td><td class="new day" data-date="1704067200000">1</td><td class="new day" data-date="1704153600000">2</td><td class="new day" data-date="1704240000000">3</td><td class="new day" data-date="1704326400000">4</td><td class="new day" data-date="1704412800000">5</td><td class="new day" data-date="1704499200000">6</td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-months" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2023</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="month">Jan</span><span class="month">Feb</span><span class="month">Mar</span><span class="month">Apr</span><span class="month">May</span><span class="month">Jun</span><span class="month">Jul</span><span class="month">Aug</span><span class="month">Sep</span><span class="month">Oct</span><span class="month">Nov</span><span class="month focused">Dec</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-years" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2020-2029</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="year old">2019</span><span class="year">2020</span><span class="year">2021</span><span class="year">2022</span><span class="year focused">2023</span><span class="year">2024</span><span class="year">2025</span><span class="year">2026</span><span class="year">2027</span><span class="year">2028</span><span class="year">2029</span><span class="year new">2030</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-decades" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2000-2090</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="decade old">1990</span><span class="decade">2000</span><span class="decade">2010</span><span class="decade focused">2020</span><span class="decade">2030</span><span class="decade">2040</span><span class="decade">2050</span><span class="decade">2060</span><span class="decade">2070</span><span class="decade">2080</span><span class="decade">2090</span><span class="decade new">2100</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div><div class="datepicker-centuries" style="display: none;"><table class="table-condensed"><thead><tr><th colspan="7" class="datepicker-title" style="display: none;"></th></tr><tr><th class="prev">«</th><th colspan="5" class="datepicker-switch">2000-2900</th><th class="next">»</th></tr></thead><tbody><tr><td colspan="7"><span class="century old">1900</span><span class="century focused">2000</span><span class="century">2100</span><span class="century">2200</span><span class="century">2300</span><span class="century">2400</span><span class="century">2500</span><span class="century">2600</span><span class="century">2700</span><span class="century">2800</span><span class="century">2900</span><span class="century new">3000</span></td></tr></tbody><tfoot><tr><th colspan="7" class="today" style="display: none;">Today</th></tr><tr><th colspan="7" class="clear" style="display: none;">Clear</th></tr></tfoot></table></div></div> -->