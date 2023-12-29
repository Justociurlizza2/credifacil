<?php

function printer ($data) : String 
{
    $file    = __DIR__."/style.css";
    $fhandle = fopen($file, "r");
    $style   = fread($fhandle, filesize($file));  /* Incrustaremos Estilos de style.css */
    fclose($fhandle);
    return '<html>
        <head>
            <style>'.$style.'</style>
        </head>
        <div>
            from, Wiedens MultiPOS :
            <table>
                <tr class="g-mob">
                    <td style="width:40%" class="w-mob">
                        <img width="100%" 
                            style="display:block;min-height:300px;text-align:center"
                            src="cid:goolem"
                        >
                    </td>
                    <td style="background:rebeccapurple;width:60%" class="w-mob">
                        <p style="font-size:16px;color:white;padding:15px">'.$data['main'].'</p>
                    </td>
                </tr>
            </table><br>
    
            <a href="'.$data['url'].'">Click this for more information</a>
            En caso de no aplicar la notificación a su interes, favor ignore este mensaje.
            Muchas gracias :| <br>
            Your Wiedens Payment Team
        </div>
    </html>';
}