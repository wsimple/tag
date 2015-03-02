<?php

?>

<table width="650" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
    <td>
        <fieldset>
            <legend>Form Spam</legend>
            <form id="spam" name="spam" method="post" action="" class="formulario">
                
                <table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
                    <tr>
                        <td class="etiquetas" style="text-align:left">Destination:</td>
                    </tr>
                    <tr>
                        <td>
                             <select name="type_destination" id="type_destination" onchange="if (this.value!='') ir_url ('controladores/spam/sendmails.control.php?tabla='+this.value, 'sent_process'); ">
                                 <option value="">---</option>
                                 <option value="spam_empresas">Business</option>
                                 <option value="spam_personas">People</option>
                             </select>                       
                        </td>
                    </tr>
                    <tr>
                        <td id="sent_process">&nbsp;</td>
                    </tr>
                </table>
                
            </form>
        </fieldset>
    </td>
    </tr>
</table>   
