import { Cliente } from '../Models/Cliente.js';
// import {Global} from '../../public/js/Helpers/exGlobal.js';
const body = {
    id: 45,
    codigo: 17004,
    idc: 2,
    credito: 1200.20,
    cuota: 1200.20,
    tasa: 1200.20,
    periodo: 9,
    inicio: '12/12/2023'
}
let client = new Cliente();
const list = await client.find('/find?link=id&equal=1')
console.log('list', list)
console.log('body', list.body)
list.body.forEach(cli => {
    console.log('ele', cli)
});
