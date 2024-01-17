import { Auth } from '../Auth.js';
let iAuth = new Auth();
export class Cuota {
    constructor() {
        this.api = 'https://credifacil.wiedens.com/Api/cuotas';
        this.uri = this.api;
    }
    calculate(cuota) {
        let body = JSON.stringify(cuota);
        this.uri = this.api + '/micuota';
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
        return resp;
    }
}
//# sourceMappingURL=Cuota.js.map