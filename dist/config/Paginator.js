let current_page = 1;
let boxy = document.createElement('boxy');
export class Paginator {
    constructor(instance) {
        this.paginationDiv = document.getElementById('pagination');
        this.rows = 2;
        this.lastPage = () => {
            let p = Number(localStorage.getItem('page'));
            if (p < 1)
                return;
            let child = this.paginationDiv.childNodes[p - 1];
            if (child !== undefined)
                child.click();
        };
        this.instance = instance;
    }
    DisplayList(items, wrapper, rows_per_page = this.rows, page = 1) {
        this.rows = rows_per_page;
        wrapper.innerHTML = "";
        let start = rows_per_page * (page - 1);
        let end = start + rows_per_page;
        let paginatedItems = items.slice(start, end);
        return paginatedItems;
    }
    SetupPagination(items, wrapper, rows_per_page = this.rows) {
        wrapper.innerHTML = "";
        let page_count = Math.ceil(items.length / rows_per_page);
        for (let i = 1; i < page_count + 1; i++) {
            let btn = this.PaginationButton(i, items, rows_per_page);
            btn.classList.add('page');
            wrapper.appendChild(btn);
        }
        ;
        this.lastPage();
    }
    PaginationButton(page, items, rows) {
        const pageInstance = this.instance;
        let button = document.createElement('button');
        button.innerText = JSON.stringify(page);
        if (current_page == page)
            button.classList.add('active');
        button.addEventListener('click', function () {
            current_page = Number(page);
            localStorage.setItem('page', JSON.stringify(page));
            let parent = new Paginator(pageInstance);
            let newSlice = parent.DisplayList(items, boxy, rows, current_page);
            pageInstance.displayContent(newSlice);
            let current_btn = document.querySelector('.pagenumbers button.active');
            current_btn.classList.remove('active');
            button.classList.add('active');
        });
        return button;
    }
    selectorResources() {
        const renderDiv = document.getElementById('renderDiv');
        const pageInstance = this.instance;
        const clickedCupon = renderDiv.querySelectorAll('.settup');
        for (let c = 0; c < clickedCupon.length; c++) {
            clickedCupon[c].onclick = function () {
                let ide = clickedCupon[c].getAttribute('ide');
                pageInstance.selectResource(ide);
            };
        }
    }
}
//# sourceMappingURL=Paginator.js.map