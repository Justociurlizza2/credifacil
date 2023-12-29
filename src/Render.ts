import config from './config/config.json' assert {type: 'json'};
export class Render {
    private modules: string[] = ['main'];
    constructor(template: string, modules?: string[])
    {

    }
    renderize(): void
    {
        let url = 'Router/AdminTemplate.php';
        const body = new FormData(); 
        body.append('render', 'main')
        setTimeout(() => {
            fetch(url, { method: 'POST', body} ).then(r => r.text())
            .then(rs => {
                    let page = <HTMLElement>document.getElementById('page');
                    page.innerHTML = rs;
                    history.pushState(null, 'Main', '/main');
                    this.setHead()
                }
            )
        }, 2000);
    }
    setHead(): void
    {
        let array = config.dependencies;
        console.log('array', array)
        let head = document.getElementsByTagName('head')[0];
        array.forEach(dependency => {
            let script = document.createElement("script");
            let base = 'public/assets/js/';
            // script.id='form'+dependency
            // script.defer=true;
            script.src= base + dependency;
            head.appendChild(script)
        });
    }
}