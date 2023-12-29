'use strict';
let drop;
let topsearch = document.getElementById('top-search')
let navproductos = document.getElementById('products_nav')
if(screen.width < 524) { 
    drop = document.getElementById('buscador')
    navproductos = document.getElementById('dropdown_mob')
}
topsearch.onkeyup = (e) => { if(point == 'e-guias') return
    topsearch.classList.add('d-block')
    CoreProductosBuscador(e, navproductos, count)
    .then(() => { 
            document.querySelectorAll('.prod').forEach(p => {
            p.onclick = (e) => { pendingProds(p, e) }
        })
    })
}
/************************* Buscador de productos *************************/
function buscarProductos (e, drop) {                    
    drop.classList.add('d-block')
    CoreProductosBuscador(e, products_list, conteo)
    .then(() => { 
            document.querySelectorAll('.prod').forEach(p => {
            p.onclick = (e) => { getProps(e) }
        })
    })
}
/*-------------- target | printer container | contador --------------*/
async function CoreProductosBuscador (e, drop, count) {
    await fetch(url+'productos?like=titulo&equal='+e.target.value, { headers }).then(r => r.json())
    .then(res => { let chart = ``;
        if(res.status !== 200) { drop.innerHTML = ``; count.innerHTML = 0; return }
        count.innerHTML = res.result.length
        res.result.forEach(prod => {
            let img = JSON.parse(prod.imagen)[0]
            chart+= `<a href="javascript:void(0);" class="dropdown-item notify-item prod"
                id="${prod.id}" img="${img}" name="${prod.titulo}" precio="${prod.precio}"
                caf="${prod.caf}" uni="${prod.unidad}">
                <div class="d-flex">
                    <img class="d-flex me-2 rounded-circle" src="${img}" alt="img-product" height="32">
                    <div class="w-100">
                        <h5 class="m-0 font-14">${prod.titulo}</h5>
                        <span class="font-12 mb-0">${prod.pco}</span>
                    </div>
                </div>
            </a>`;
        });
        drop.innerHTML = chart
    })
}
/************************* Componentes Clientes *************************/
function buscarClientes(drop, e, key) {
    person_dropdown.classList.add('d-block')
    fetch(url+'clientes?like='+ key +'&equal='+e.target.value, { headers }).then(r => r.json())
    .then(res => { let chart = ``;
        if(res.status !== 200) { drop.innerHTML = ``; conteo1.innerHTML = `0` ; return }
        conteo1.innerHTML = res.result.length
        res.result.forEach(prov => {
            chart+= `<a class="dropdown-item notify-item cli" id="${prov.id}" name="${prov.razon}" doc="${prov.nrodoc}" comp="${prov.compras}">
                <div class="d-flex">
                    <img class="d-flex me-2 rounded-circle" src="vistas/assets/images/users/avatar-2.jpg" alt="Generic placeholder image" height="32">
                    <div class="w-100">
                        <h5 class="m-0 font-14">${prov.razon}</h5>
                        <span class="font-12 mb-0">${prov.nrodoc}</span>
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
                console.log('compras', cli.getAttribute('comp'))
                if(document.getElementById('compras')) compras.innerHTML = cli.getAttribute('comp')
                // compras.innerHTML = drop.getAttribute('money')
            }
        });
    })
}
/*-------------- Fast Client register | No - email  --------------*/
let his = {"2023":{"1":{"total":0,"pe":[],"ve":[],"pa":[]},"2":{"total":0,"pe":[],"ve":[],"pa":[]},"3":{"total":0,"pe":[],"ve":[],"pa":[]},"4":{"total":0,"pe":[],"ve":[],"pa":[]},"5":{"total":0,"pe":[],"ve":[],"pa":[]},"6":{"total":0,"pe":[],"ve":[],"pa":[]},"7":{"total":0,"pe":[],"ve":[],"pa":[]},"8":{"total":0,"pe":[],"ve":[],"pa":[]},"9":{"total":0,"pe":[],"ve":[],"pa":[]},"10":{"total":0,"pe":[],"ve":[],"pa":[]},"11":{"total":0,"pe":[],"ve":[],"pa":[]},"12":{"total":0,"pe":[],"ve":[],"pa":[]}},"2024":{"1":{"total":0,"pe":[],"ve":[],"pa":[]},"2":{"total":0,"pe":[],"ve":[],"pa":[]},"3":{"total":0,"pe":[],"ve":[],"pa":[]},"4":{"total":0,"pe":[],"ve":[],"pa":[]},"5":{"total":0,"pe":[],"ve":[],"pa":[]},"6":{"total":0,"pe":[],"ve":[],"pa":[]},"7":{"total":0,"pe":[],"ve":[],"pa":[]},"8":{"total":0,"pe":[],"ve":[],"pa":[]},"9":{"total":0,"pe":[],"ve":[],"pa":[]},"10":{"total":0,"pe":[],"ve":[],"pa":[]},"11":{"total":0,"pe":[],"ve":[],"pa":[]},"12":{"total":0,"pe":[],"ve":[],"pa":[]}}}
function EasyClientRegister () {
    let uri = 'https://www.wiedens.com/APIpos/';
    if(cliente.value.length < 8) { errorPopup('danger', 'Nombre completo por favor'); return; }
    if(cliente.value.split(' ').length < 2) { errorPopup('danger', 'Ingrese Nombres y apellidos'); return; }
    let body = {
        razon       : cliente.value.toUpperCase(),
        tipodoc     : 1,
        nrodoc      : numero.value,
        password    : '123',
        email       : '',
        historial   : JSON.stringify(his)
    }
    console.log('fast-cli', body)
    body = JSON.stringify(body)
    fetch(uri+'clientes?register=true', { method:'POST', body, headers }).then(r => r.json())
    .then(res => {
        if(res.status !== 200) { errorPopup(res.result); return; }
        errorPopup(res.result, 'success')
    })
}
/************************* Componente para copy - paste *************************/
document.querySelectorAll('.mdi-content-copy').forEach(copy => {
    copy.onclick = (e) => {
        let area = document.createElement('textarea');
        let txt = e.target.parentElement.childNodes[0].innerHTML.replace(/-/g, '')
        let t = document.createTextNode(txt);
        area.appendChild(t);
        document.body.appendChild(area);
        area.select();
        document.execCommand('copy');
        area.style.visibility = 'hidden'
        errorPopup('success', 'N° Guía: '+ txt +' copiada!');
    }
});