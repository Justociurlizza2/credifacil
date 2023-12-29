/************************* Componentes Clientes *************************/
import { Global } from './exGlobal.js'
const global = new Global();
 
const url = 'https://credifacil.wiedens.com/Api/'
let headers = { "Authorization": `Bearer `+localStorage.getItem('ustoken') }
let conteo = document.getElementById('conteo');
export class Helper {
    buscarClientes(drop, e, key) {
        person_dropdown.classList.add('d-block')
        // console.log('ev', e)
        // console.log('evalue', e.target.value)
        fetch(url+'clientes/findlike?link='+ key +'&equal='+e.target.value, { headers }).then(r => r.json())
        .then(res => { let chart = ``;
            if(res.status !== 200) { 
                drop.innerHTML = ``; conteo.innerHTML = `0` ;
                global.errorPopup('danger', res.body)
                return 
            }
            conteo.innerHTML = res.body.length
            res.body.forEach(prov => {
                chart+= `<a class="dropdown-item notify-item cli" id="${prov.id}" name="${prov.razon}" doc="${prov.nrodoc}" comp="${prov.deuda}">
                    <div class="d-flex">
                        <img class="d-flex me-2 rounded-circle" src="public/design/modern/images/users/avatar-2.jpg" alt="Generic placeholder image" height="32">
                        <div class="w-100">
                            <h5 class="m-0 fs-3">${prov.razon}</h5>
                            <span class="fs-2 mb-0">${prov.nrodoc}</span>
                        </div>
                    </div>
                </a>`;
            });
            drop.innerHTML = chart
            document.querySelectorAll('.cli').forEach(cli => {
                cli.onclick = () => { 
                    cliente.value   = cli.getAttribute('name')
                    numero.value    = cli.getAttribute('doc')
                    idc.value       = cli.getAttribute('id')
                    console.log('idc', idc)
                    console.log('compras', cli.getAttribute('comp'))
                    if(document.getElementById('compras')) compras.innerHTML = cli.getAttribute('comp')
                    // compras.innerHTML = drop.getAttribute('money')
                }
            });
        })
    }
}