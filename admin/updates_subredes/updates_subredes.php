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

require_once('../../include/library.php');
anti_spy();
// Fun��o para replica��o do conte�do do REPOSIT�RIO nos servidores de UPDATES das redes cadastradas.
	if ($_REQUEST['v_parametros']<>'')
		{

		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
		<head>
		<link rel="stylesheet"   type="text/css" href="../../include/cacic.css">
	
		<title>Verifica&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o dos Servidores de Updates</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		</head>
		<body background="../../imgs/linha_v.gif">
		<script language="JavaScript" type="text/javascript" src="../../include/cacic.js"></script>	
		<table width="90%" border="0" align="center">
		<tr nowrap> 
		<td class="cabecalho">Verifica&ccedil;&atilde;o dos Servidores de Updates das Redes</td>
		</tr>
		<tr> 
		<td class="descricao">M&oacute;dulo para verifica&ccedil;&atilde;o/atualiza&ccedil;&atilde;o das vers&otilde;es 
		dos objetos localizados nos servidores de updates das redes monitoradas.</td>
		</tr>
		</table>
		<br>
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#666666">
		<tr bordercolor="#000000" bgcolor="#CCCCCC">	
		<td valign="center" class="cabecalho_tabela">
		<p align="left">IP da Rede</p>
		</td>

		<td valign="center" class="cabecalho_tabela">
		<p align="left">&nbsp;&nbsp;&nbsp;</p>
		</td>
		
		<td valign="center" class="cabecalho_tabela">
		<p align="left">Nome da Rede
		</p>
		</td>		
		<td valign="center" class="cabecalho_tabela">
		<p align="left">&nbsp;&nbsp;&nbsp;</p>
		</td>
	
		<td valign="center" class="cabecalho_tabela">
		<p align="left">Status</p>
		</td>			
		</tr>
	
		<?
		$v_array_parametros = explode('_-_',$_REQUEST['v_parametros']);
		$v_array_redes = explode('__',$v_array_parametros[1]);	

		if (count($v_array_redes)>0)
			{
			for ($i = 0;$i < count($v_array_redes);$i++)
				{
				if ($v_where <> '') $v_where .= ' or ';
				$v_where .= ' id_ip_rede="'.$v_array_redes[$i].'"';
				}
			}

		$query_REDES= "	SELECT 	re.id_ip_rede,
								re.nm_rede,
								re.id_local
					 FROM		redes re 
					 WHERE " . $v_where . 
					" ORDER BY    re.nm_rede";	
		conecta_bd_cacic();					
		$result_REDES = mysql_query($query_REDES);
		$v_tripa_servidores_updates = '';
		while ($row = mysql_fetch_array($result_REDES))
			{
			if ($v_cor_zebra == '#FFFFFF') $v_cor_zebra = '#EEEEEE'; else $v_cor_zebra = '#FFFFFF';								
			?>		
			<tr> 
			<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
			<p align="left"><? echo $row['id_ip_rede']; ?></p>
			</td>
			<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
			<p align="left">&nbsp;</p>
			</td>
		
			<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" nowrap class="opcao_tabela">
			<p align="left"><? echo $row['nm_rede']; ?></p>
			</td>
			<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
			<p align="left">&nbsp;</p>
			</td>
			<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" nowrap class="opcao_tabela_blue">
			<p align="left">
			<?
			if (@strpos($_SESSION['v_tripa_servidores_updates'],trim($row['te_serv_updates']))>0)
				{
				echo 'Verifica��o Efetuada!';																					
				}
			else
				{		
				update_subredes($row['id_ip_rede'],'Pagina','__'.$v_array_parametros[0],$row['id_local']);			
				if ($_SESSION['v_efetua_conexao_ftp'] > 0)
					{	
					echo 'Verifica��o Efetuada!';				
								
					if ($_SESSION['v_conta_objetos_atualizados'] > 0)
						{
						$v_array_objetos_atualizados = explode('#',$_SESSION['v_tripa_objetos_atualizados']);
						for ($cnt_objetos = 0; $cnt_objetos < count($v_array_objetos_atualizados); $cnt_objetos++)
							{
							?>
							<tr> 
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
						
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="atualizado">
							<p align="left">Atualizando <? echo $v_array_objetos_atualizados[$cnt_objetos];?>...
							<?					
							}						
						}
					if ($_SESSION['v_conta_objetos_nao_atualizados'] > 0)
						{
						$v_array_objetos_nao_atualizados = explode('#',$_SESSION['v_tripa_objetos_nao_atualizados']);					
						for ($cnt_objetos = 0; $cnt_objetos < count($v_array_objetos_nao_atualizados); $cnt_objetos++) 					
							{
							?>
							<tr> 
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
					
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
							<p align="left">&nbsp;</p>
							</td>
							<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="nao_atualizado">
							<p align="left">N�o Atualizado: <? echo $v_array_objetos_nao_atualizados[$cnt_objetos];?>!						
							<?					
							}						
						}
					if ($_SESSION['v_conta_objetos_enviados'] > 0)
						{
						$v_array_objetos_enviados = explode('#',$_SESSION['v_tripa_objetos_enviados']);					
						for ($cnt_objetos = 0; $cnt_objetos < count($v_array_objetos_enviados); $cnt_objetos++) 					
							{
							if (trim($v_array_objetos_enviados[$cnt_objetos])<>'')
								{					
								?>
								<tr> 
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
						
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="enviado">
								<p align="left">Enviando <? echo $v_array_objetos_enviados[$cnt_objetos];?>...							
								<?					
								}
							}						
						 }
					if ($_SESSION['v_conta_objetos_nao_enviados'] > 0)
						{
						$v_array_objetos_nao_enviados = explode('#',$_SESSION['v_tripa_objetos_nao_enviados']);					
						for ($cnt_objetos = 0; $cnt_objetos < count($v_array_objetos_nao_enviados); $cnt_objetos++) 					
							{
							if (trim($v_array_objetos_nao_enviados[$cnt_objetos])<>'' && trim($v_array_objetos_nao_enviados[$cnt_objetos])<>'versoes_agentes.ini')
								{
								?>
								<tr> 
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
			
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="opcao_tabela">
								<p align="left">&nbsp;</p>
								</td>
								<td valign="center" bgcolor="<? echo $v_cor_zebra;?>" class="nao_enviado">
								<p align="left">N�o Enviado <? echo $v_array_objetos_nao_enviados[$cnt_objetos];?>!
								<?					
								}
							}						
						}										
					}									
				else if($_SESSION['v_status_conexao'] == 'NC')
					{
					echo '<a href="../redes/detalhes_rede.php?id_ip_rede='. $row['id_ip_rede'] .'" style="color: red"><strong>FTP n�o configurado!</strong></a>';										
					}
				else if($_SESSION['v_status_conexao'] == 'OFF')
					{
					echo '<a href="../redes/detalhes_rede.php?id_ip_rede='. $row['id_ip_rede'] .'" style="color: red"><strong>Servidor OffLine!</strong></a>';																				
					}
				}
			}
			?>
			</p>
			</td>			
			</tr>			
			<?
		$_SESSION['v_conta_objetos_enviados'] 			= 	0;
		$_SESSION['v_conta_objetos_nao_enviados']		= 	0;
		$_SESSION['v_conta_objetos_atualizados']		=	0;
		$_SESSION['v_conta_objetos_nao_atualizados']	= 	0;
		
		session_unregister('v_conta_objetos_enviados');
		session_unregister('v_conta_objetos_nao_enviados');
		session_unregister('v_conta_objetos_atualizados');
		session_unregister('v_conta_objetos_nao_atualizados');
		session_unregister('v_tripa_objetos_enviados');
		session_unregister('v_tripa_objetos_nao_enviados');
		session_unregister('v_tripa_objetos_atualizados');
		session_unregister('v_tripa_objetos_nao_atualizados');
		session_unregister('v_tripa_servidores_updates');	
		session_unregister('v_efetua_conexao_ftp');
		session_unregister('v_conexao_ftp');
	
		?>
		<tr bordercolor="#000000" bgcolor="#999999">
		<td valign="center" class="opcao_tabela">
		<p align="left">&nbsp;</p>
		</td>
		<td valign="center" class="opcao_tabela">
		<p align="left">&nbsp;</p>
		</td>
	
		<td valign="center" class="opcao_tabela">
		<p align="left">&nbsp;</p>
		</td>		
		<td valign="center" class="opcao_tabela">
		<p align="left">&nbsp;</p>
		</td>
	
		<td valign="center" class="opcao_tabela">
		<p align="left">&nbsp;</p>
		</td>			
		</tr>	
	
		</table>	
		</body>
		</html>
		<?
		}
		?>