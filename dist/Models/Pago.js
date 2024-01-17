import { Auth } from '../Auth.js';
let iAuth = new Auth();
export class Pago {
    constructor() {
        this.api = 'https://credifacil.wiedens.com/Api/pagos';
        this.uri = this.api;
    }
    create(cuota) {
        this.uri = this.api + '/pagar';
        console.log('data-pago', cuota);
        let body = JSON.stringify(cuota);
        return this.fetch({ method: 'POST', body });
    }
    index() {
        return this.fetch({ method: 'GET' });
    }
    find(uri) {
        this.uri = this.uri + uri;
        return this.fetch({ method: 'GET' });
    }
    async fetch(options) {
        options.headers = iAuth.getHeaders();
        const resp = await fetch(this.uri, options)
            .then(r => r.json());
        console.log('resp-pago', resp);
        return resp;
    }
}
//# sourceMappingURL=Pago.js.map