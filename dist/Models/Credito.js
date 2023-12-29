import { Auth } from '../Auth.js';
let iAuth = new Auth();
export class Credito {
    constructor() {
        this.api = 'https://credifacil.wiedens.com/Api/creditos';
        this.uri = this.api;
    }
    create(credito) {
        this.uri = this.api;
        let body = JSON.stringify(credito);
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
//# sourceMappingURL=Credito.js.map