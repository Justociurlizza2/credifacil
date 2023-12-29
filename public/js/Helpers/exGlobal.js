// ___________________________ System Alerts ___________________________
const popup = document.querySelector('.popup')
const closes = document.querySelectorAll('.btn-close');
closes.forEach(close => {
    close.addEventListener('click', (e) => {
        e.preventDefault(); popup.id = 'hide' }) 
});
export class Global {
    errorPopup(type, message) {
        let stat = 'popup alert customize-alert alert-dismissible fade show remove-close-icon ';
        let newClass = stat+'text-'+type+' alert-light-'+type+' bg-'+type+'-subtle';
        popup.className = newClass
        popup.childNodes[3].childNodes[3].innerHTML = message;
        popup.id = 'show'
        if(type==='success') { setTimeout(() => { popup.id = 'hide' }, 4500) }
    }
}