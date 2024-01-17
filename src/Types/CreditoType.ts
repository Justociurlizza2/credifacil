export type CreditoType = {
    readonly id?: number,
    readonly codigo?: number,
    readonly idc: number,
             credito: number,
             cuota: number,
             tasa: number,
             periodo: number,
             inicio: string,
             tipo: number
}
export type getCreditoType = {
    readonly id?: number,
    readonly codigo?: number,
    readonly idc: number,
             credito: number,
             tasa: number,
             periodo: number,
             inicio: string,
             tipo: number,
             monto: number,
             cliente: {
              razon: string,
              nrodoc: string  
             },
             cuota: {
                cuota: number,
                monto: number
             },
             fin: string,
             estado: number
}

export const Status = {
    0:  {stat: 'Registrado',color: 'light'},
    1:  {stat: 'Aprobado',  color: 'success'},
    2:  {stat: 'Pagándose', color: 'primary'},
    5:  {stat: 'Pagado',    color: 'warning'},
    9:  {stat: 'Anulado',   color: 'danger'}
}

const date = new Date();
const hoy = String(date.getDate()).padStart(2, '0')+'-'+ String(date.getMonth()+1).padStart(2, '0')+'-'+ date.getFullYear()
export const base = {
    credito: 200,
    nlapsos: 30,
    tasa: 10,
    periodo: 7,
    tipo: 30,
    inicio: hoy
}