import { Render } from "./Render.js";
export class Auth {
    private headers: HeadersInit = {};
    constructor() 
    {
        this.setHeader()
    }

    getToken(): string
    {
        let token = localStorage.getItem('ustoken')
        if(token == null) token = 'none'
        return token;
    }
    setToken(token: string): void
    {
        localStorage.setItem('ustoken', token);
        this.setHeader()
    }
    setHeader(): void
    {
        this.headers = { 
            "Authorization": this.getBearerToken(),
            'Cache-Control': 'no-cache'
        }
    }
    getHeaders(): HeadersInit
    {
        return this.headers
    }
    getBearerToken(): string
    {
        return 'Bearer '+this.getToken();
    }
    accessAdmin(): void
    {
        let render = new Render('Admin');
        render.renderize();
    }
}
console.log('auth-origin')