let current_page: number = 1;
let boxy = <HTMLElement>document.createElement('boxy');

export class Paginator {
    public instance: InstanceType<any>;
    public paginationDiv = <HTMLElement>document.getElementById('pagination')
    public rows:number = 2
    constructor(instance: InstanceType<any>)
    {
        this.instance = instance
    }
    DisplayList(items: any[], wrapper: HTMLElement, rows_per_page: number = this.rows, page: number = 1): object[]
    {
        this.rows = rows_per_page
        wrapper.innerHTML = "";
        let start = rows_per_page * (page - 1);
        let end = start + rows_per_page;
        let paginatedItems: object[] = items.slice(start, end);
        return paginatedItems;
    }
    SetupPagination (items: any[], wrapper: HTMLElement, rows_per_page: number = this.rows){
        wrapper.innerHTML = "";
        let page_count = Math.ceil(items.length / rows_per_page);
        for(let i = 1; i < page_count + 1; i++){
            let btn = this.PaginationButton(i, items, rows_per_page);
            btn.classList.add('page')
            wrapper.appendChild(btn);
        }; this.lastPage()
    }
    PaginationButton(page: number, items: any[], rows: number)
    {
        const pageInstance = this.instance
        let button:any = document.createElement('button');
        button.innerText = JSON.stringify(page);
        if(current_page == page) button.classList.add('active');
        button.addEventListener('click', function() {
            current_page = Number(page);
            localStorage.setItem('page', JSON.stringify(page));    //________________ Guardamos la página
            let parent = new Paginator(pageInstance)
            let newSlice: any[] = parent.DisplayList(items, boxy, rows, current_page);
            pageInstance.displayContent(newSlice);

            let current_btn = <HTMLElement>document.querySelector('.pagenumbers button.active');
            current_btn.classList.remove('active');
            button.classList.add('active');
        });
        return button;
    }
    selectorResources()
    {
        const renderDiv:any = document.getElementById('renderDiv');
        const pageInstance = this.instance
        const clickedCupon:any = renderDiv.querySelectorAll('.settup');
        for(let c=0; c<clickedCupon.length; c++){
            clickedCupon[c].onclick = function(){
                let ide = clickedCupon[c].getAttribute('ide')
                pageInstance.selectResource(ide);
                // postButton.innerHTML = 'Actualizar'
                // return;
            }
        }
    }
    lastPage = () => {
        let p = Number(localStorage.getItem('page'));   if(p < 1) return
        let child:any = this.paginationDiv.childNodes[p-1];
        if(child !== undefined) child.click()
    }
}