'use strict';
function getProperties (dom) {                  // funcion que retorna un objeto con claves como id del dom
    let properties = {}
    const domInputs = dom.querySelectorAll('[idata]')
    // for (const input of domInputs) { let nameId = input.getAttribute('id') properties[nameId] = input.value }
    domInputs.forEach(input => {
        let nameId = input.getAttribute('id')
        properties[nameId] = input.value
    });
    return properties;
}
function setProperties (dom, obj) {             // funcion que setea un dom con claves de un objeto
    const domInputs = dom.querySelectorAll('[idata]')
    domInputs.forEach(input => {
        let nameId = input.getAttribute('idata').includes('.') ? input.getAttribute('idata') : input.getAttribute('id')
        let campos = nameId.split('.')
        if(campos.length > 1) {                 // campos de recurso como rs.proveedor.razon
            if(obj[campos[0]][campos[1]] !== undefined) input.value = obj[campos[0]][campos[1]]
        } else {
            if(obj[nameId] !== undefined) input.value = obj[nameId] // dom prop no está en el objeto
        }
    });
}
function printProperties (dom, obj) {           // funcion que prime texto al dom por claves - objeto
    const domInputs = dom.querySelectorAll('[txt]')
    domInputs.forEach(input => {
        let nameId = input.getAttribute('txt')  // capturamos inclusive txt="sucursal.id"
        let campos = nameId.split('.')
        if(campos.length > 1) {                 // campos de recurso como rs.proveedor.razon}
            input.innerHTML = obj[campos[0]][campos[1]] || 'Sin '+ campos[1]
        } else {
            if(obj[nameId] !== undefined) input.innerHTML = obj[nameId] // dom prop no está en el objeto
        }
    });
}

function CleanerBody (body, label) {
    let pattern = '<'+ label + ' [^>]*>';       // patrón segun etiqueta
    let exp = new RegExp(`${pattern}`, "g")     // Expresión regex según patrón
    let txt = body.replace(exp, "<b>");         // Replace con regex a <b>
    let split = txt.split('<b>')                // División con <b>
    let res = split.pop()                       // último elemento del array body
    // console.log('cleaner', res)
    return res                                  
    // let msg = proof.replace(/<br [^>]*>/g,"<b>");
    // msg = msg.replace(/<*[^>]b>/g,"<b>");
}
function outerHTML(node) { return node.outerHTML || new XMLSerializer().serializeToString(node) }
function CamelCase (string) {
    const palabras = string.split(" ");
    for (let i = 0; i < palabras.length; i++) {
        palabras[i] = palabras[i][0].toUpperCase() + palabras[i].substr(1);
    }
}