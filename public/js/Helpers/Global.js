var image; console.log('plantilla')
let links = document.querySelectorAll('li a span')
const point = location.pathname.split('/')[2] // Production point = (1)
links.forEach(function(link) {
    if(link.parentNode.getAttribute('href') === point) link.parentElement.classList.add('backColor')
    if(point == "payments") links[6].parentElement.classList.add('backColor')
})
function validateJSA(event, type){
    let parent = $(event.target).parent();
    /*_____________________ Validamos Texto _____________________*/
    if(type == "text"){
        var pattern = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/;
        if(!pattern.test(event.target.value)) automatic('Do not use numbers or special characters')
        parent.children(".invalid-feedback").css({"display":"none"});
    }
    if(type == "address"){
        var pattern = /^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\A-Za-zñÑáéíóúÁÉÍÓÚ0&+-9- ]{1,}$/;
        if(!pattern.test(event.target.value)) automatic('Do not use numbers or special characters')
        else parent.children(".invalid-feedback").css({"display":"none"});
    }
    if(type == "number"){
        var pattern = /^[0-9 ]{1,}$/;
        if(!pattern.test(event.target.value)){ automatic('Only use numbers')
        } parent.children(".invalid-feedback").css({"display":"none"});
    }
    /*_____________________ Validamos Email _____________________*/
    if(type == "email"){
        var pattern = /^[^0-9][.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;
        if(!pattern.test(event.target.value)) automatic('The email is misspelled')
        else parent.children(".invalid-feedback").css({"display":"none"});
    }
    /*_____________________ Validamos Password _____________________*/
    if(type == "password"){
        var pattern = /^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/;
        if(!pattern.test(event.target.value)) { 
            automatic('The password is not acepted'), event.target.value = "";
        } else parent.children(".invalid-feedback").css({"display":"none"});
    }
    /*_____________________ Validamos Images _____________________*/
    if(type == "image") {
        let images = event.target.files;
        for (let i = 0; i < images.length; i++) { const image = images[i];
            /*_____________________ Validamos Formato _____________________*/
            if(image["type"] !== "image/jpeg" && image["type"] !== "image/png"){
                swal("error", "La imagen/archivo " +Number(i+1)+ " debe ser de formato JPG o PNG", null)
                return false
            }
            /*_____________________ Validamos Tamaño _____________________*/
            if(image["size"] > 2000000){
                swal("error", "La imagen " +Number(i+1)+ " no debe pesar más de 2MB", null)
                return false
            }
            /*__________________ Mostramos Imagen temporal __________________*/
            if(i === images.length - 1) { return true }
        }
    }
    function automatic (text) {
        parent.addClass("was-validated");
        parent.children(".invalid-feedback").css({"display":"block"});
        parent.children(".invalid-feedback").html(text);
    }
}
/*_____________________ Buscador Universal _____________________*/
let current_page = 1; 
const pagination_element = document.getElementById('pagination');
let boxy = document.querySelector('.boxy')
function searchParams (text, params) {
    let expresion = new RegExp(`${text}.*`, "i"); let filters = [];
    for (const p of params) {
        let fil = reqs.filter(req =>expresion.test(req[p]))
        if(fil.length) { filters = [...filters, ...fil] }
    }
    let slice = DisplayList(filters, boxy, rows, 1);
    DisplayContent(slice)
    SetupPagination(filters, pagination_element, rows);
}
const lastPage = () => {
    let p = Number(localStorage.getItem('page'));   if(p < 1) return
    let child = pagination.childNodes[p-1];
    if(child !== undefined) child.click()
}
function DisplayList (items, wrapper, rows_per_page, page){
    wrapper.innerHTML = "";
	let start = rows_per_page * (page - 1);
	let end = start + rows_per_page;
    let paginatedItems = items.slice(start, end);
    return paginatedItems;
}
function SetupPagination (items, wrapper, rows_per_page){
	wrapper.innerHTML = "";
	let page_count = Math.ceil(items.length / rows_per_page);
	for(let i = 1; i < page_count + 1; i++){
		let btn = PaginationButton(i, items, rows_per_page);
        btn.classList.add('page')
		wrapper.appendChild(btn);
	}; lastPage()
}
function PaginationButton(page, items, rows){
	let button = document.createElement('button');
	button.innerText = page;
	if(current_page == page) button.classList.add('active');
	button.addEventListener('click', function() {
        current_page = Number(page);
        if(!boxy) boxy = seccion1
        localStorage.setItem('page', page );    //________________ Guardamos la página
        let newSlice = DisplayList(items, boxy, rows, current_page);
        if(point === 'mispedidos' || point === 'miscompras') DisplayContentP(newSlice)
        else DisplayContent(newSlice);
		let current_btn = document.querySelector('.pagenumbers button.active');
		current_btn.classList.remove('active');
		button.classList.add('active');
	});
	return button;
}
function trToggle(){
    let trToggle = document.querySelectorAll('.tr');
    const clickedCupon = document.querySelectorAll('.settup');
    for(let c=0; c<clickedCupon.length; c++){
        clickedCupon[c].onclick = function(){
            let ide = clickedCupon[c].parentNode.getAttribute('ide')
            console.log('id', ide)
            getElement(ide);
            postButton.innerHTML = 'Actualizar'
            return;
        }
    }
    for(let i=0;i<trToggle.length;i++) {
        let tdFirst = trToggle[i].childNodes[1].childNodes[1].classList
        trToggle[i].onclick = function() {
            trToggle[i].classList.toggle('active');
            if(tdFirst.contains('sorting3')) tdFirst.add('sorting4'), tdFirst.remove('sorting3');
            else tdFirst.add('sorting3'), tdFirst.remove('sorting4');
        }
    }
}
// ___________________________ System Alerts ___________________________
const popup = document.querySelector('.popup')
const closes = document.querySelectorAll('.btn-close');
closes.forEach(close => {
    close.addEventListener('click', (e) => {
        e.preventDefault(); popup.id = 'hide' }) 
});
function errorPopup(type, message) {
    let stat = 'popup alert customize-alert alert-dismissible fade show remove-close-icon ';
    let newClass = stat+'text-'+type+' alert-light-'+type+' bg-'+type+'-subtle';
    popup.className = newClass
    popup.childNodes[3].childNodes[3].innerHTML = message;
    popup.id = 'show'
    if(type==='success') { setTimeout(() => { popup.id = 'hide' }, 4500) }
}
$(document).on('change', '#datepicker', function(){ datepicker.value = $("#datepicker").val() })