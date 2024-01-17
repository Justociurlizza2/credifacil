import { CreditoType } from '../Types/CreditoType.js';
import { Auth } from '../Auth.js';
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
export class Credito {
    public api = 'https://credifacil.wiedens.com/Api/creditos';
    private uri: string = this.api;
    constructor()
    {
    }
    create (credito: CreditoType): any
    {
        this.uri = this.api+'/create'
        let body = JSON.stringify(credito)
        return this.fetch({method: 'POST', body})
    }
    index(): any
    {
       return this.fetch({method: 'GET'})
    }
    find(uri: string): any
    {
        this.uri = this.uri+uri
        return this.fetch({method: 'GET'})
    }
    async fetch(options: HttpRequest): Promise<HttpResponse>
    {
        options.headers = iAuth.getHeaders()
        const resp = await fetch(this.uri, options)
        .then(r => r.json())
        console.log('new-credito', resp)
        return resp;
    }
}