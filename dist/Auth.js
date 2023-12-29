import { Render } from "./Render.js";
export class Auth {
    constructor() {
        this.headers = {};
        this.setHeader();
    }
    getToken() {
        let token = localStorage.getItem('ustoken');
        if (token == null)
            token = 'none';
        return token;
    }
    setToken(token) {
        localStorage.setItem('ustoken', token);
        this.setHeader();
    }
    setHeader() {
        this.headers = {
            "Authorization": this.getBearerToken(),
            'Cache-Control': 'no-cache'
        };
    }
    getHeaders() {
        return this.headers;
    }
    getBearerToken() {
        return 'Bearer ' + this.getToken();
    }
    accessAdmin() {
        let render = new Render('Admin');
        render.renderize();
    }
}
console.log('auth-origin');
//# sourceMappingURL=Auth.js.map