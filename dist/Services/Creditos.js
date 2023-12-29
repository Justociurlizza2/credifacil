import { Credito } from '../Models/Credito.js';
import { Cuota } from '../Models/Cuota.js';
import { Cliente } from '../Models/Cliente.js';
import { CreditoView } from '../Views/CreditoView.js';
import { Global } from '../../public/js/Helpers/exGlobal.js';
import { Helper } from '../../public/js/Helpers/exHelper.js';
import { Utils } from '../../public/js/Utils/exUtils.js';
export default class Creditos {
}
const credito = new Credito();
const cuota = new Cuota();
const client = new Cliente();
const global = new Global();
const utils = new Utils();
let data = {};
let quota = {};
const cuotaDt = document.getElementById('cuotaDetalle');
const form = document.getElementById('form');
const time = document.querySelectorAll('[time]');
const plazo = document.getElementById('plazo');
form.onchange = () => { data = utils.getProperties(form); console.log('data', data); };
let times = Array.prototype.slice.call(time);
times.forEach(factor => {
    factor.onchange = () => { calcPlazo(); };
});
function calcPlazo() {
    let p = plazo;
    let update = Array.prototype.slice.call(time);
    let factors = update.map(f => Number(f.value));
    let calc = factors.reduce((f1, f2) => f1 * f2);
    p.value = `${calc}`;
}
const buttonCuota = document.getElementById('buttonCuota');
const buttonCredito = document.getElementById('buttonCredito');
buttonCredito.onclick = () => { newCredito(); };
buttonCuota.onclick = () => {
    getCuota().then((r) => printCuota(r));
};
async function getCuota() {
    let data = utils.getProperties(form);
    delete data.id;
    const calc = await cuota.calculate(data);
    if (calc.status !== 200) {
        global.errorPopup('danger', calc.body);
        return {};
    }
    global.errorPopup('success', 'Cuota generada: s/ ' + calc.body.cuota);
    quota = calc.body;
    return quota;
}
function printCuota(quota) {
    if (!quota)
        return;
    utils.printProperties(cuotaDt, quota);
}
async function newCredito() {
    let data = utils.getProperties(form);
    delete data.id;
    const con = await credito.create(data);
    if (con.status !== 200) {
        global.errorPopup('danger', con.body);
        return {};
    }
    global.errorPopup('success', '¡Muy bien! ' + con.body);
    return con.body;
}
const lastView = document.getElementById('lastView');
const creditoView = new CreditoView();
credito.find('/findlike?link=id&equal').then(r => {
    if (r.status !== 200) {
        global.errorPopup('danger', r.body);
        return;
    }
    creditoView.renderCreditos(r.body);
});
lastView.onclick = () => { creditoView.swithView(); };
export function getResource() {
    console.log('getResource in creditos');
}
const helper = new Helper();
const icliente = document.getElementById('cliente');
const inumero = document.getElementById('numero');
const dropCliente = document.getElementById('persons_list');
icliente.onkeyup = (e) => { helper.buscarClientes(dropCliente, e, 'razon'); };
icliente.onclick = (e) => { helper.buscarClientes(dropCliente, e, 'razon'); };
inumero.onkeyup = (e) => { helper.buscarClientes(dropCliente, e, 'nrodoc'); };
inumero.onclick = (e) => { helper.buscarClientes(dropCliente, e, 'nrodoc'); };
//# sourceMappingURL=Creditos.js.map