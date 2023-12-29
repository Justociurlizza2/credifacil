import { CuotaType } from '../Types/CuotaType.js';
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
export class Cuota {
    public api = 'https://credifacil.wiedens.com/Api/cuotas';
    private uri: string = this.api;
    constructor()
    {
    }
    calculate (cuota: CuotaType): any
    {
        let body = JSON.stringify(cuota)
        this.uri = this.api + '/micuota';
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
        console.log('cuotas', resp)
        return resp;
    }
}