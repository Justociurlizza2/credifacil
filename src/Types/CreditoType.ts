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