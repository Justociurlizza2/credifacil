import { Credito } from '../Models/Credito.js';
import { Global } from '../../public/js/Helpers/exGlobal.js';
import { Status } from '../Types/CreditoType.js';
import { Tasas } from '../Types/CuotaType.js';
import { Utils } from '../../public/js/Utils/exUtils.js';
import { Paginator } from '../config/Paginator.js';
const utils = new Utils();
const credito = new Credito();
const cuotaDetalle = document.getElementById('cuotaDetalle');
const renderform = document.getElementById('renderform');
const renderDiv = document.getElementById('renderDiv');
const render = document.getElementById('render');
const form = document.getElementById('form');
export class CreditoView {
    constructor() {
        this.paginator = new Paginator(this);
    }
    renderCreditos(creditos) {
        this.swithView();
        let slice = this.paginator.DisplayList(creditos, render, 2, 1);
        this.paginator.SetupPagination(creditos, this.paginator.paginationDiv);
        this.displayContent(slice);
    }
    printCredito(credito) {
        let rand = Math.floor(Math.random() * (3) + 1);
        console.log('rand', rand);
        return `<div class="col-xl-4 d-flex align-items-strech">
            <div class="card w-100">
                <div class="position-relative">
                    <img src="public/assets/images/crypto/c${rand}.jpg" class="card-img" alt="nft">
                    <span class="badge text-bg-${Status[credito.estado].color} fs-2 rounded-4 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">
                        ${Status[credito.estado].stat}
                    </span>
                </div>

                <div class="p-4 mt-n4 text-center">
                    <div class="position-relative mt-n4">
                        <img src="public/assets/images/profile/user-5.jpg" alt="nft" class="rounded-circle border border-3 border-white" width="50">
                    </div>
                    <div><h6 class="mb-0 fw-semibold mt-2">${credito.cliente.razon}</h6></div>
                    <div
                        class="d-flex align-items-center justify-content-between mt-2 pb-3 border-bottom">
                        <div class="text-start">
                            <span class="fs-3">Crédito</span>
                            <h6 class="mb-0 fw-semibold">${credito.credito} PEN</h6>
                        </div>
                        <div class="text-end">
                            <span class="fs-3">Cuota</span>
                            <h6 class="mb-0 fw-semibold">${credito.cuota.cuota} PEN</h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 pt-3">
                        <div>
                            <button class="btn btn-primary rounded-circle round p-0 settup" ide="${credito.id}">
                                <i class="ti ti-player-play fs-5"></i>
                            </button>
                        </div>
                        <div style="width:90px">
                            <h6 class="mb-0 fw-semibold">s/ ${credito.cuota.monto}</h6>
                            <span class="fs-2">${credito.fin}</span>
                        </div>
                        <div class="ms-auto text-end">
                            <span class="text-success">+${credito.tasa}%</span>
                            <span class="fs-2">${Tasas[credito.tipo]}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }
    displayContent(creditos) {
        let print = '';
        creditos.forEach(credito => {
            print += this.printCredito(credito);
        });
        render.innerHTML = print;
        this.paginator.selectorResources();
    }
    viewCredito(credito) {
        utils.setProperties(form, credito);
        utils.printProperties(cuotaDetalle, credito.cuota);
        console.log('cliente', credito.cliente);
        const cliente = document.getElementById('cliente');
        const nrodoc = document.getElementById('numero');
        cliente.value = credito.cliente.razon;
        nrodoc.value = credito.cliente.nrodoc;
    }
    selectResource(ide) {
        const global = new Global();
        credito.find('/findlike?link=id&equal=' + ide).then(rs => {
            if (rs.status !== 200) {
                global.errorPopup('danger', rs.body);
                return;
            }
            this.swithView();
            this.viewCredito(rs.body[0]);
        });
    }
    swithView() {
        if (renderDiv.style.display == 'flex') {
            renderDiv.style.display = 'none';
            renderform.style.display = 'flex';
        }
        else {
            renderDiv.style.display = 'flex';
            renderform.style.display = 'none';
        }
    }
}
//# sourceMappingURL=CreditoView.js.map