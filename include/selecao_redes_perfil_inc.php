<?
 /* 
 Copyright 2000, 2001, 2002, 2003, 2004, 2005 Dataprev - Empresa de Tecnologia e Informa��es da Previd�ncia Social, Brasil

 Este arquivo � parte do programa CACIC - Configurador Autom�tico e Coletor de Informa��es Computacionais

 O CACIC � um software livre; voc� pode redistribui-lo e/ou modifica-lo dentro dos termos da Licen�a P�blica Geral GNU como 
 publicada pela Funda��o do Software Livre (FSF); na vers�o 2 da Licen�a, ou (na sua opni�o) qualquer vers�o.

 Este programa � distribuido na esperan�a que possa ser  util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita de ADEQUA��O a qualquer
 MERCADO ou APLICA��O EM PARTICULAR. Veja a Licen�a P�blica Geral GNU para maiores detalhes.

 Voc� deve ter recebido uma c�pia da Licen�a P�blica Geral GNU, sob o t�tulo "LICENCA.txt", junto com este programa, se n�o, escreva para a Funda��o do Software
 Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
  /* Lembre-se de setar as vari�veis 
		$cs_situacao e $id_acao 
		antes de dar um include nesse arquivo. */
?>		
<table width="100%" border="0" cellpadding="0" cellspacing="1">
          <tr> 
            <td class="label">  
<?
		$where = ($_SESSION['cs_nivel_administracao']<>1 && $_SESSION['cs_nivel_administracao']<>2?' AND redes.id_local = '.$_SESSION['id_local']:'');

		$queryRedes = "SELECT 	distinct redes.id_ip_rede, 
								redes.nm_rede,
								redes.id_local ".
								$select . "
					  FROM 		redes ".
					  			$from . 
								$where ."
					  ORDER BY  nm_rede";
		$resultRedes = mysql_query($queryRedes) or die('Problema no acesso � tabela Redes ou sua sess�o expirou!');	
		$msg = '(OBS: Est�o sendo exibidas somente as redes selecionadas pelo administrador.)';

		$redesDisponiveis  = '';
		$redesSelecionadas = '';		
		
		/* Agora monto os itens do combo de redes dispon�veis. */ 
		while($campos=mysql_fetch_array($resultRedes)) 	
			{
			if ($select) // Chamada originada da p�gina de detalhes...
				{
				if ($campos['IdLocalAR']=='')
				   	$redesDisponiveis  .= '<option value="' . $campos['id_local'].'_'.$campos['id_ip_rede']. '">' . $campos['id_ip_rede'] . ' - ' . capa_string($campos['nm_rede'], 35) . '</option>';
				else
				   	$redesSelecionadas .= '<option value="' . $campos['id_local'].'_'.$campos['id_ip_rede']. '">' . $campos['id_ip_rede'] . ' - ' . capa_string($campos['nm_rede'], 35) . '</option>';			
				}
			else
			   	$redesDisponiveis  .= '<option value="' . $campos['id_local'].'_'.$campos['id_ip_rede']. '">' . $campos['id_ip_rede'] . ' - ' . capa_string($campos['nm_rede'], 35) . '</option>';			
			}  

			
			?>
              Selecione as redes: </td>
          </tr>
          <tr> 
            <td height="1" bgcolor="#333333"></td>
          </tr>
          <tr> 
            <td><table border="0" cellpadding="0" cellspacing="0">
			
                <tr> 
                  <td>&nbsp;&nbsp;</td>
                  <td class="cabecalho_tabela"><div align="left">Dispon&iacute;veis:</div></td>
                  <td>&nbsp;&nbsp;</td>
                  <td width="40">&nbsp;</td>
                  <td nowrap>&nbsp;&nbsp;</td>
                  <td nowrap class="cabecalho_tabela">Selecionadas:<br></td>
                  <td nowrap>&nbsp;&nbsp;</td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td> <div align="left"> 
                      <select multiple size="10" name="list1[]" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
                        <? echo $redesDisponiveis; ?> 
                      </select>
                      </div></td>
                  <td>&nbsp;</td>
                  <td width="40"> <div align="center"> 
                      <input type="button" value="   &gt;   " onClick="move(this.form.elements['list1[]'],this.form.elements['list2[]'])" name="B1">
                      <br>
                      <br>
                      <input type="button" value="   &lt;   " onClick="move(this.form.elements['list2[]'],this.form.elements['list1[]'])" name="B2">
                    </div></td>
                  <td>&nbsp;</td>
                  <td><select multiple size="10" name="list2[]" class="normal" onFocus="SetaClassDigitacao(this);" onBlur="SetaClassNormal(this);" >
                        <? echo $redesSelecionadas; ?> 				  
                    </select></td>
                  <td>&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td class="descricao">&nbsp;&nbsp;(Dica: 
              use SHIFT ou CTRL para selecionar m&uacute;ltiplos itens)</td>
          </tr>
</table>
