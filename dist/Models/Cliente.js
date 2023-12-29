import { Auth } from '../Auth.js';
import { Global } from '../../public/js/Helpers/exGlobal.js';
let iAuth = new Auth();
export class Cliente {
    constructor() {
        this.uri = 'https://credifacil.wiedens.com/Api/clientes';
    }
    create() {
        let global = new Global();
        global.errorPopup('info', 'probando el test desde credito.ts');
        return;
    }
    index() {
        return this.fetch({ method: 'GET' });
    }
    find(params = '') {
        this.uri = this.uri + params;
        return this.fetch({ method: 'GET' });
    }
    async fetch(options) {
        options.headers = iAuth.getHeaders();
        const resp = await fetch(this.uri, options)
            .then(r => r.json());
        return resp;
    }
}
//# sourceMappingURL=Cliente.js.map