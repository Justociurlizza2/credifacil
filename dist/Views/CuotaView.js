import { Cuota } from '../Models/Cuota.js';
import { Global } from '../../public/js/Helpers/exGlobal.js';
import { Status } from '../Types/CuotaType.js';
import { Utils } from '../../public/js/Utils/exUtils.js';
import { Paginator } from '../config/Paginator.js';
const utils = new Utils();
const cuota = new Cuota();
const cuotaDetalle = document.getElementById('cuotaDetalle');
const renderform = document.getElementById('renderform');
const renderDiv = document.getElementById('renderDiv');
const render = document.getElementById('render');
const form = document.getElementById('form');
export class CuotaView {
    constructor() {
        this.paginator = new Paginator(this);
    }
    renderCuotas(cuotas) {
        this.swithView();
        let slice = this.paginator.DisplayList(cuotas, render, 7, 1);
        this.paginator.SetupPagination(cuotas, this.paginator.paginationDiv);
        this.displayContent(slice);
    }
    printCuota(cuota) {
        let rand = Math.floor(Math.random() * (3) + 1);
        let fecha = cuota.inicio.split(' ')[0];
        let status = Status[cuota.stat];
        return `<div class="col-lg-4 d-flex align-items-strech">
            <div class="card text-bg-${status.color} border-0 w-100">
                <div class="card-body pb-0 p-3">
                    <h5 class="fw-semibold mb-1 text-white card-title">s/ ${cuota.cuota}</h5>
                    <p class="fs-3 mb-0 text-white">${cuota.cliente.razon}</p>
                    <span class="fs-2 text-white yt">${fecha}</span>
                    <div class="text-center mt-0">
                        <img src="public/assets/images/backgrounds/piggy.png" class="img-fluid" alt="">
                        <span class="badge rounded-pill font-medium bg-dark-subtle text-${status.line} fs-2 rounded-4 lh-sm mt-3 me-9 py-1 px-2 fw-semibold position-absolute top-0 end-0">
                            ${status.stat}
                        </span>
                    </div>
                </div>
                <div class="card mx-2 mb-2 mt-n2">
                    <div class="card-body p-3">
                        <div class="mb-4 pb-1">
                            <div class="d-flex justify-content-between align-items-center mb-6">
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">Deuda s/ <span txt="monto">${cuota.monto}</span></h6>
                                    <p class="fs-3 mb-0"><span>Pagando s/ ${cuota.monto}</span></p>
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
                            <button type="button" class="justify-content-center w-100 btn mb-1 bg-success-subtle text-success font-medium d-flex align-items-center
                                settup" ide="${cuota.id}">
                                <i class="ti ti-coin fs-6 me-2"></i>
                                Cobrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }
    displayContent(cuotas) {
        let print = '';
        cuotas.forEach(cuota => {
            print += this.printCuota(cuota);
        });
        render.innerHTML = print;
        this.paginator.selectorResources();
        this.selectResource(4);
    }
    viewcuota(cuota) {
        utils.setProperties(form, cuota);
        utils.printProperties(cuotaDetalle, cuota);
        const cliente = document.getElementById('cliente');
        const nrodoc = document.getElementById('numero');
        cliente.value = cuota.cliente.razon;
        nrodoc.value = cuota.cliente.nrodoc;
    }
    selectResource(ide) {
        const global = new Global();
        cuota.find('/findlike?link=id&equal=' + ide).then(rs => {
            if (rs.status !== 200) {
                global.errorPopup('danger', rs.body);
                return;
            }
            this.swithView();
            this.viewcuota(rs.body[0]);
        });
    }
    swithView() {
        if (renderDiv.style.display == '') {
            renderDiv.style.display = 'none';
            renderform.style.display = '';
        }
        else {
            renderDiv.style.display = '';
            renderform.style.display = 'none';
        }
    }
}
//# sourceMappingURL=CuotaView.js.map