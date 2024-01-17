export type CuotaType = {
    readonly codigo: number,
    readonly idc?: number,
             credito: number,
             tasa: number,
             tipo: number,
             plazo: number,
             periodo: number
}

export type getCuotaType = {
    readonly id?: number,
    readonly codigo?: number,
    readonly idc?: number,
             credito: number,
             tasa: number,
             tipo: number,
             plazo: number,
             periodo: number,
             cuota: number,
             monto: number,
             inicio: string,
             cliente: {
                razon: string,
                nrodoc: string  
               },
               stat: number
}

export const Tasas = {
    1:  'Tasa diaria',
    7:  'Tasa semanal',
    15: 'Tasa quincenal',
    30: 'Tasa mensual',
    360:'Tasa anual'
}

export const Status = {
    0:  {stat: 'Pendiente', color: 'primary', line: 'danger'},
    5:  {stat: 'Pagado',    color: 'success', line: 'primary'},
    9:  {stat: 'Anulado',   color: 'danger',   line: ''}
}