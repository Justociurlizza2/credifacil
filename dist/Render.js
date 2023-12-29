import config from './config/config.json' assert { type: 'json' };
export class Render {
    constructor(template, modules) {
        this.modules = ['main'];
    }
    renderize() {
        let url = 'Router/AdminTemplate.php';
        const body = new FormData();
        body.append('render', 'main');
        setTimeout(() => {
            fetch(url, { method: 'POST', body }).then(r => r.text())
                .then(rs => {
                let page = document.getElementById('page');
                page.innerHTML = rs;
                history.pushState(null, 'Main', '/main');
                this.setHead();
            });
        }, 2000);
    }
    setHead() {
        let array = config.dependencies;
        console.log('array', array);
        let head = document.getElementsByTagName('head')[0];
        array.forEach(dependency => {
            let script = document.createElement("script");
            let base = 'public/assets/js/';
            script.src = base + dependency;
            head.appendChild(script);
        });
    }
}
//# sourceMappingURL=Render.js.map