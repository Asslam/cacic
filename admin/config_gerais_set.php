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
session_start();
/*
 * verifica se houve login e tamb�m as permiss�es de usu�rio
 */
if(!isset($_SESSION['id_usuario'])) 
  die('Acesso negado!');
else { // Inserir regras para verificar permiss�es do usu�rio!
}
require_once('../include/library.php');
// Comentado temporariamente - AntiSpy();
conecta_bd_cacic();

// Preciso remover os "Enters" dados nos campos texto do formul�rio, pois a rotina de envio de emails
// estava dando erro quando encontrava esse tipo de caractere especial.				
$te_notificar_mudanca_hardware = str_replace("\r\n", " ", $_POST['te_notificar_mudanca_hardware']);

	$query = "UPDATE	configuracoes_locais set 
	          			te_notificar_mudanca_hardware	= '" . $te_notificar_mudanca_hardware . "', 
			  			te_serv_cacic_padrao 			= '" . $_POST['frm_te_serv_cacic_padrao'] . "', 			  
			  			te_serv_updates_padrao 			= '" . $_POST['frm_te_serv_updates_padrao'] . "'
			   WHERE	id_local = ".$_SESSION['id_local'];			  
  
	$result = mysql_query($query) or die('Ocorreu um erro durante a atualiza��o da tabela configuracoes.'); 
	GravaLog('INS',$_SERVER['SCRIPT_NAME'],'configuracoes_locais');		
	// Aqui pego todas os hardwares selecionados para notifica��o e atualizo a tabela descricao_hardware .
	$hardwares_selecionados = "'" . $_POST['list2'][0] . "'";
	for( $i = 1; $i < count($_POST['list2']); $i++ ) {
		$hardwares_selecionados = $hardwares_selecionados . ",'" . $_POST['list2'][$i] . "'";
	}
	$hardwares_selecionados = ' nm_campo_tab_hardware IN ('. $hardwares_selecionados .')';

	$query = "UPDATE 	descricao_hardware set 
	          			cs_notificacao_ativada = '0'";
	$result = mysql_query($query) or die('Ocorreu um erro durante a atualiza��o da tabela descricao_hardware.'); 
	$query = "UPDATE 	descricao_hardware set 
	          			cs_notificacao_ativada = '1'
			  WHERE 	" . $hardwares_selecionados;
	$result = mysql_query($query) or die('Ocorreu um erro durante a atualiza��o da tabela descricao_hardware.'); 

	header ("Location: ../include/operacao_ok.php?chamador=../admin/config_gerais.php&tempo=1");		
	
?>
