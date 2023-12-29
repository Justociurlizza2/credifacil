import { Auth } from '../Auth.js';
import { Global } from '../../public/js/Helpers/exGlobal.js';
let iAuth = new Auth()
type HttpResponse = {
    status: number,
    body: any,
    total: number
}
type HttpRequest = {
    method?: string,
    body?: string,
    headers?: HeadersInit
}
export class Cliente {
    public uri = 'https://credifacil.wiedens.com/Api/clientes';
    constructor()
    {
    }
    create (): void
    {
        let global = new Global()
        global.errorPopup('info', 'probando el test desde credito.ts');
        return
    }
    index(): any
    {
       return this.fetch({method: 'GET'})
    }
    find(params: string = ''): any
    {
        this.uri = this.uri + params;
        return this.fetch({method: 'GET'})
    }
    
    async fetch(options: HttpRequest): Promise<HttpResponse>
    {
        options.headers = iAuth.getHeaders()
        const resp = await fetch(this.uri, options)
        .then(r => r.json())
        return resp;
    }
}