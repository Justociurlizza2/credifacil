'use scrict'
import { Auth } from '../../../dist/Auth.js';
import  config  from '../js/config.json' assert {type: 'json'};

let iAuth = new Auth();

let url = 'https://credifacil.wiedens.com/Api/'
const form = document.getElementById('form')
form.addEventListener('submit', e => { 
    // postForm.disabled = true;
    e.preventDefault();
    if(document.getElementById('login').value == 1) login()
    else storeData()
})
function storeData() {
    let body = getProperties(form)
    console.log('body', body)
    delete body.cpassword
    body = JSON.stringify(body)
    fetch(url+'emisores/register', { method: 'POST', body: body} ).then(r => r.json())
    .then(res => { 
        postForm.disabled = false
        console.log('res', res)
        // if(res.status !== 200) { errorPopup('danger', res.result); return; }
        // errorPopup('success', res.result)
    })
}

function login () {
    let body = getProperties(form)
    console.log('body', body)
    body = JSON.stringify(body)
    fetch(url+'miusuario/login', { method: 'POST', body} ).then(r => r.json())
    .then(res => {
        postForm.disabled = false
        console.log('res', res)
        if(res.status !== 200) { errorPopup('danger', res.body); return; }
        errorPopup('success', 'Autenticación exitosa')
        iAuth.setToken(res.body)
        iAuth.accessAdmin()

        let url = 'Router/AdminTemplate.php';
        // let body = JSON.stringify({render: 'main'})
        const body = new FormData(); 
        body.append('render', 'main')
        // fetch(url, { method: 'POST', body} )
        // .then(r => r.text())
        // .then(res => {
        //     console.log('res', res)
        // })
    })
}