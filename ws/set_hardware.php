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
// Defini��o do n�vel de compress�o (Default = 9 => m�ximo)
//$v_compress_level = 9;
$v_compress_level = 0;  // Mantido em 0(zero) para desabilitar a Compress�o/Decompress�o 
						// H� necessidade de testes para An�lise de Viabilidade T�cnica 

require_once('../include/library.php');

// Essas vari�veis conter�o os indicadores de criptografia e compacta��o
$v_cs_cipher	= (trim($_POST['cs_cipher'])   <> ''?trim($_POST['cs_cipher'])   : '4');
$v_cs_compress	= (trim($_POST['cs_compress']) <> ''?trim($_POST['cs_compress']) : '4');

autentica_agente($key,$iv,$v_cs_cipher,$v_cs_compress);

// Obtenho o IP da esta��o por meio da decriptografia...
$v_id_ip_estacao = trim(DeCrypt($key,$iv,$_POST['id_ip_estacao'],$v_cs_cipher,$v_cs_compress));

// ...caso o IP esteja inv�lido, obtenho-o a partir de vari�vel do servidor
if (substr_count($v_id_ip_estacao,'zf')>0 || trim($v_id_ip_estacao)=='')
	$v_id_ip_estacao = 	$_SERVER['REMOTE_ADDR'];

$te_node_address 	= DeCrypt($key,$iv,$_POST['te_node_address']	,$v_cs_cipher, $v_cs_compress); 
$id_so_new         	= DeCrypt($key,$iv,$_POST['id_so']				,$v_cs_cipher, $v_cs_compress); 
$te_so           	= DeCrypt($key,$iv,$_POST['te_so']				,$v_cs_cipher, $v_cs_compress); 
$id_ip_rede     	= DeCrypt($key,$iv,$_POST['id_ip_rede']			,$v_cs_cipher, $v_cs_compress);
$te_nome_computador	= DeCrypt($key,$iv,$_POST['te_nome_computador']	,$v_cs_cipher, $v_cs_compress); 
$te_workgroup 		= DeCrypt($key,$iv,$_POST['te_workgroup']		,$v_cs_cipher, $v_cs_compress); 

$strTripa_CPU   	= DeCrypt($key,$iv,$_POST['te_Tripa_CPU']  		,$v_cs_cipher, $v_cs_compress);				
$strTripa_CDROM 	= DeCrypt($key,$iv,$_POST['te_Tripa_CDROM']		,$v_cs_cipher, $v_cs_compress);
$strTripa_TCPIP 	= DeCrypt($key,$iv,$_POST['te_Tripa_TCPIP']		,$v_cs_cipher, $v_cs_compress);

// Todas as vezes em que � feita a recupera��o das configura��es por um agente, � inclu�do 
//  o computador deste agente no BD, caso ainda n�o esteja inserido. 
if ($te_node_address <> '')
	{ 
	$arrSO = inclui_computador_caso_nao_exista(	$te_node_address, 
												$id_so_new, 
												$te_so, 										
												$id_ip_rede, 
												$v_id_ip_estacao, 
												$te_nome_computador, 
												$te_workgroup);										

	conecta_bd_cacic();

	$strQueryTotalizaGeralExistentes = ' SELECT  count(cs_tipo_componente) TotalGeralExistentes
								 		 FROM	 componentes_estacoes
										 WHERE   te_node_address = "'.$te_node_address . '" AND
									 		 	  			id_so='  . $arrSO['id_so'];
	$resultTotalizaGeralExistentes   = mysql_query($strQueryTotalizaGeralExistentes) or die('Problema Consultando Tabela Componentes_Esta��es 1!');
	$rowTotalizaGeralExistentes      = mysql_fetch_array($resultTotalizaGeralExistentes);	

	// ================================================================================
	// A fun��o VerificaComponentes retornar� um array contendo os seguintes elementos:
	// ================================================================================
	// ACR     => Acrescentados
	// REM     => Removidos
	// ALT     => Alterados
	// ALT_OLD => Registros Antigos, afetados pelas ALTERA��ES
	// ================================================================================
	
	// Itens de componentes CDROM								
	// --------------------------
	// 00 - CDROMName
	$arrCDROM 	= VerificaComponentes('CDROM',$strTripa_CDROM,$rowTotalizaGeralExistentes['TotalGeralExistentes']);	

	// Itens de componentes CPU
	// ------------------------
	// 00 - CPUName
	// 01 - Vendor
	// 02 - Serial Number
	// 03 - Frequency
	$arrCPU 	= VerificaComponentes('CPU',$strTripa_CPU,$rowTotalizaGeralExistentes['TotalGeralExistentes']);

	// Itens de componentes TCPIP
	// --------------------------
	// 00 - Name
	// 01 - PhysicalAddress
	// 02 - IPAddress
	// 03 - IPMask
	// 04 - Gateway_IPAddress
	// 05 - DHCP_IPAddress
	// 06 - PrimaryWINS_IPAddress
	// 07 - SecondaryWINS_IPAddress
	$arrTCPIP	= VerificaComponentes('TCPIP',$strTripa_TCPIP,$rowTotalizaGeralExistentes['TotalGeralExistentes']);	
		
	if ($arrCDROM['ACR'] <> '' ||
		$arrCDROM['REM'] <> '' ||
		$arrCDROM['ALT'] <> '' ||	
		$arrCPU['ACR']   <> '' ||
		$arrCPU['REM']   <> '' ||
		$arrCPU['ALT']   <> '' ||		    
		$arrTCPIP['ACR'] <> '' ||
		$arrTCPIP['REM'] <> '' ||
		$arrTCPIP['ALT'] <> '')
		{
		$v_dados_rede = getDadosRede();
				
	    // Agora, verifico se os administradores dever�o ser notificados da altera��o na configura��o de hardware.
	  	if (trim($destinatarios = get_valor_campo('configuracoes_locais', 'te_notificar_mudanca_hardware','id_local='.$v_dados_rede['id_local'])) <> '') 
			{
	        // Consulto lista de colunas de hardware
			$queryDescricoesColunas  = "SELECT 	nm_campo, 
									 			te_descricao_campo
					  				    FROM 	descricoes_colunas_computadores";
			$resultDescricoesColunas = mysql_query($queryDescricoesColunas) or die('Ocorreu um erro durante a consulta � tabela descricoes_colunas_computadores.');

			// Crio um array que conter� nm_campo => te_descricao_campo.	 
			$arrDescricoesColunas = array();			
			while($rowColunasComputadores = mysql_fetch_array($resultDescricoesColunas)) 	
				$arrDescricoesColunas[trim($rowColunasComputadores['nm_campo'])] = $rowColunasComputadores['te_descricao_campo'];

			
	        // Consulto todos os hardwares que foram selecionados para notificacao. Isso � setado pelo administrador na p�gina de 'Configura��es Gerais'.
			$queryColunasSelecionadas  = "SELECT 	nm_campo_tab_hardware, 
													te_desc_hardware
					  					  FROM 		descricao_hardware 
					  					  WHERE 	te_locais_notificacao_ativada like '%,".$v_dados_rede['id_local'].",%'";
			$resultColunasSelecionadas = mysql_query($queryColunasSelecionadas) or die('Ocorreu um erro durante a consulta � tabela descricao_hardware.');

			// Crio um array que conter� nm_campo_tab_hardware => te_desc_hardware.	 
			$arrColunasSelecionadas = array();			
			while($rowColunasSelecionadas = mysql_fetch_array($resultColunasSelecionadas)) 	
				$arrColunasSelecionadas[trim($rowColunasSelecionadas['nm_campo_tab_hardware'])] = $rowColunasSelecionadas['te_desc_hardware'];

			$cont_aux = 0;
			$campos_alterados = '';

		
			// =====================================================================================
			// ================ In�cio do Tratamento de ACRESCENTADOS ==============================
			// =====================================================================================			
			$campos_alterados .= TrataAlteracoes('CDROM, CPU, TCPIP', $arrColunasSelecionadas,$arrDescricoesColunas);
GravaTESTES('Campos_Alterados: '.$campos_alterados);			
			/*
			// =====
			// CDROM
			// =====
			$boolConteudo = false;
			$arrAcrescentadosCDROM = explode('#CDROM#',$arrCDROM['ACR']);
			for ($i=0; $i < count($arrAcrescentadosCDROM); $i++) 
				{
				$arrItensAcrescentadosCDROM = explode('###',$arrAcrescentadosCDROM[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensAcrescentadosCDROM); $j+=2)
					if ($arrItensAcrescentadosCDROM[$j])				
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensAcrescentadosCDROM[$j])] .': '.$arrItensAcrescentadosCDROM[$j+1].'\n';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Acrescentados:<br><br>':'').$campos_alterados.'<br>';

			// ===
			// CPU
			// ===
			$boolConteudo = false;
			$arrAcrescentadosCPU = explode('#CPU#',$arrCPU['ACR']);
			for ($i=0; $i < count($arrAcrescentadosCPU); $i++) 
				{
				$arrItensAcrescentadosCPU = explode('###',$arrAcrescentadosCPU[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensAcrescentadosCPU); $j+=2)
					if ($arrItensAcrescentadosCPU[$j])				
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensAcrescentadosCPU[$j])] .': '.$arrItensAcrescentadosCPU[$j+1].'\n';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Acrescentados:<br><br>':'').$campos_alterados.'<br>';

			// =====
			// TCPIP
			// =====
			$boolConteudo = false;
			$arrAcrescentadosTCPIP = explode('#CPU#',$arrTCPIP['ACR']);
			for ($i=0; $i < count($arrAcrescentadosTCPIP); $i++) 
				{
				$arrItensAcrescentadosTCPIP = explode('###',$arrAcrescentadosTCPIP[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensAcrescentadosTCPIP); $j+=2)
					if ($arrItensAcrescentadosTCPIP[$j])				
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensAcrescentadosTCPIP[$j])] .': '.$arrItensAcrescentadosTCPIP[$j+1].'\n';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Acrescentados:<br><br>':'').$campos_alterados.'<br>';

			// ==================================================================================
			// ================ Fim do Tratamento de ACRESCENTADOS ==============================
			// ==================================================================================			


			// REMOVIDOS
			// =========
			$boolConteudo = false;
			$arrRemovidosCDROM = explode('#CDROM#',$arrCDROM['REM']);
			for ($i=0; $i < count($arrRemovidosCDROM); $i++) 
				{
				$arrItensRemovidosCDROM = explode('###',$arrRemovidosCDROM[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensRemovidosCDROM); $j+=2)
					if ($arrItensRemovidosCDROM[$j])				
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensRemovidosCDROM[$j])] .': '.$arrItensRemovidosCDROM[$j+1].'<br>';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Removidos:<br><br>':'').$campos_alterados.'<br>';
			
			// ALTERADOS
			// =========
			$boolConteudo = false;
			$arrAlteradosCDROM = explode('#CDROM#',$arrCDROM['ALT']);
			for ($i=0; $i < count($arrAlteradosCDROM); $i++) 
				{
				$arrItensAlteradosCDROM = explode('###',$arrAlteradosCDROM[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensAlteradosCDROM); $j+=2)
					if ($arrItensAlteradosCDROM[$j])
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensAlteradosCDROM[$j])] .': '.$arrItensAlteradosCDROM[$j+1].'<br>';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Alterados:<br><br>':'').$campos_alterados;
			
			// ================== Fim do Tratamento de ACRESCENTADOS ===============================
			
			/*
			// ================ In�cio do Tratamento de ACRESCENTADOS ==============================			

			// CDROM
			// =============
			$boolConteudo = false;
			$arrAcrescentadosCDROM = explode('#CDROM#',$arrCDROM['ACR']);
			for ($i=0; $i < count($arrAcrescentadosCDROM); $i++) 
				{
				$arrItensAcrescentadosCDROM = explode('###',$arrAcrescentadosCDROM[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensAcrescentadosCDROM); $j+=2)
					if ($arrItensAcrescentadosCDROM[$j])				
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensAcrescentadosCDROM[$j])] .': '.$arrItensAcrescentadosCDROM[$j+1].'\n';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Acrescentados:<br><br>':'').$campos_alterados.'<br>';

			// REMOVIDOS
			// =========
			$boolConteudo = false;
			$arrRemovidosCDROM = explode('#CDROM#',$arrCDROM['REM']);
			for ($i=0; $i < count($arrRemovidosCDROM); $i++) 
				{
				$arrItensRemovidosCDROM = explode('###',$arrRemovidosCDROM[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensRemovidosCDROM); $j+=2)
					if ($arrItensRemovidosCDROM[$j])				
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensRemovidosCDROM[$j])] .': '.$arrItensRemovidosCDROM[$j+1].'<br>';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Removidos:<br><br>':'').$campos_alterados.'<br>';
			
			// ALTERADOS
			// =========
			$boolConteudo = false;
			$arrAlteradosCDROM = explode('#CDROM#',$arrCDROM['ALT']);
			for ($i=0; $i < count($arrAlteradosCDROM); $i++) 
				{
				$arrItensAlteradosCDROM = explode('###',$arrAlteradosCDROM[$i]);
				$campos_alterados .= ($campos_alterados?'<br><br>':'');
				for ($j=0; $j < count($arrItensAlteradosCDROM); $j+=2)
					if ($arrItensAlteradosCDROM[$j])
						{
						$campos_alterados .= $descricoes_campos[trim($arrItensAlteradosCDROM[$j])] .': '.$arrItensAlteradosCDROM[$j+1].'<br>';
						$boolConteudo = true;
						}
				}

			if ($boolConteudo)
				$campos_alterados = ($campos_alterados?'Itens Alterados:<br><br>':'').$campos_alterados;
			
			// ================== Fim do Tratamento de ACRESCENTADOS ===============================
			*/

			// ================== In�cio da Montagem do Email ======================================				
			 if ($campos_alterados <> '') 
				{ 
				$corpo_mail = '';
				$corpo_mail .= " Prezado administrador,\n\n";
				$corpo_mail .= " foi identificada uma altera��o na configura��o de hardware do seguinte computador:\n\n";				
				$corpo_mail .= " Nome...........: ". $te_nome_computador ."\n";
				$corpo_mail .= " Endere�o IP: ". $v_id_ip_estacao . "\n";
				$corpo_mail .= " Rede............: ". $v_dados_rede['id_ip_rede'] ."\n\n\n";
				$corpo_mail .= " A alteracao refere-se a:\n\n";
				$corpo_mail .= str_replace('<br>',(chr(13).chr(10)),$campos_alterados) ;
				$corpo_mail .= "\n\nPara visualizar mais informa��es sobre esse computador, acesse o endere�o\nhttp://";
				$corpo_mail .= $_SERVER['SERVER_ADDR'] . '/cacic2/relatorios/computador/computador.php?te_node_address=' . $te_node_address . '&id_so=' . $arrSO['id_so'];
				$corpo_mail .= "\n\n\n________________________________________________\n";
				$corpo_mail .= "CACIC - " . date('d/m/Y H:i') . "h \n";
				$corpo_mail .= "Desenvolvido pela Dataprev - Unidade Regional Esp�rito Santo";
	
				// Manda mail para os administradores.
				mail("$destinatarios", "[Sistema CACIC] Alteracao de Hardware Detectada", "$corpo_mail", "From: cacic@{$_SERVER['SERVER_NAME']}");
				GravaTESTES('EMAIL ENVIADO!');
				}
			else
				GravaTESTES('EMAIL N�O ENVIADO!');			
				
			}
		}
	echo '<?xml version="1.0" encoding="iso-8859-1" ?><STATUS>OK</STATUS>';	
	}
else
	echo '<?xml version="1.0" encoding="iso-8859-1" ?><STATUS>Chave (TE_NODE_ADDRESS + ID_SO) Inv�lida</STATUS>';

// Fun��o para montagem do texto de componentes acrescentados
function TrataAlteracoes($strTripaComponentes, $arrColunasSelecionadas,$arrDescricoesColunas)
	{
	$strAlteracoes  = '';
	$arrOperacoes 	   = explode(',','REM,ACR'); 
	$arrComponentes    = explode(',',$strTripaComponentes);
	for ($g=0; $g < count($arrOperacoes); $g++)
		{
		if ($strAlteracoes)
			$strAlteracoes = ($strAlteracoes?' Itens '.($arrOperacoes[$g-1]=='ACR'?'Acrescentados':($arrOperacoes[$g-1]=='REM'?'Removidos':'Alterados')).':<br> ================<br>':'').$strAlteracoes.'<br>';			
		
		for ($h=0; $h < count($arrComponentes);$h++)
			{		
			$strNomeArrayComponente = 'arr'.trim($arrComponentes[$h]);

			// Importo a vari�vel array do componente via vari�vel-vari�vel
			global $$strNomeArrayComponente;

			$arrItensAlteracoesExterno = $$strNomeArrayComponente;

			// Explodo os tipos de componentes
			$arrAlteracoes = explode('#'.trim($arrComponentes[$h]).'#',$arrItensAlteracoesExterno[$arrOperacoes[$g]]);

			for ($i=0; $i < count($arrAlteracoes); $i++) 
				{
				// Explodo os conjuntos de campos
				$arrItensAlteracoes = explode('#FIELD#',$arrAlteracoes[$i]);
			
				// Indicador para montagem do email alerta
				$boolAlerta = false;

				// Verifico se algum campo foi selecionado para alerta de altera��o
				for ($j=0; $j < count($arrItensAlteracoes); $j++)
					if ($arrItensAlteracoes[$j])
						{
						// Explodo os campos
						$arrCampos = explode('###',$arrItensAlteracoes[$j]);					
						if ($arrColunasSelecionadas[trim($arrCampos[0])]<>'')
							{
							$boolAlerta = true;
							$j = count($arrItensAlteracoes);
							}
						}
				
				// Caso haja campo selecionado para alerta, monto informa��es para composi��o do email
				if ($boolAlerta)
					{
					for ($j=0; $j < count($arrItensAlteracoes); $j++)
						if ($arrItensAlteracoes[$j])
							{
							// Explodo os campos
							$arrCampos = explode('###',$arrItensAlteracoes[$j]);					
							$strDescricaoColuna = $arrDescricoesColunas[trim($arrCampos[0])];
							$strDescricaoColuna = ($strDescricaoColuna?$strDescricaoColuna:trim($arrCampos[0]));						
							
							if ($j == 0)										
								$strAlteracoes .= ($strAlteracoes<>''?'<br><br>':'').$arrDescricoesColunas[trim($arrCampos[0])] . '  =>  ' . $arrCampos[1].'<br>';
							else
								$strAlteracoes .= '       '. $strDescricaoColuna . ': ' . $arrCampos[1].'<br>';							
							}
					}			
				}
			}
		}		

	if ($strAlteracoes)
		$strAlteracoes = ($strAlteracoes?' Itens '.($arrOperacoes[$g-1]=='ACR'?'Acrescentados':($arrOperacoes[$g-1]=='REM'?'Removidos':'Alterados')).':<br> ================<br>':'').$strAlteracoes.'<br>';			
		
	return $strAlteracoes;
	}
	
function VerificaComponentes($strCsTipoComponente, $strTripaComponentesRecebidos, $intTotalGeralExistentes = 0)
	{
	global $te_node_address;
	global $arrSO;

	$strTripaComponentesExistentes   = '';

	$strTripaACR 	 	= '';
	$strTripaREM 	 	= '';
	$strTripaALT 	 	= '';	
	$strTripaALT_OLD 	= '';		
	$intTotalExistentes = 0;
	$intTotalRecebidos  = 0;

	$arrComponentesAcrescentados = array();
	
	// ===============================================================================
	// Monto array com tripa de valores enviada pelo agente e passada para verifica��o
	// ===============================================================================
	$strTripaComponentesRecebidosAux = $strTripaComponentesRecebidos;	
	$arrComponentesRecebidos  		 = explode('#'.$strCsTipoComponente.'#',$strTripaComponentesRecebidosAux); 							
	$intTotalRecebidos		  		 = count($arrComponentesRecebidos);

	conecta_bd_cacic();											
	

	$strQueryComponentesExistentes = '  SELECT 	 *
										FROM	 componentes_estacoes
										WHERE    te_node_address = "'.$te_node_address . '" AND
												 id_so=' . $arrSO['id_so'].' AND
												 cs_tipo_componente = "'.$strCsTipoComponente.'" 
										ORDER BY te_valor';											

	$resultComponentesExistentes = mysql_query($strQueryComponentesExistentes) or die('Problema Consultando Tabela Componentes_Esta��es 2!');
	$intTotalExistentes = @mysql_num_rows($resultComponentesExistentes);
	
	// ===============================================================================================
	// Se j� existem componentes associados � esta��o, vou tratar ACRESCENTADOS, REMOVIDOS e ALTERADOS
	// ===============================================================================================
	if ($intTotalExistentes > 0)			
		{
		while ($rowComponentesExistentes = mysql_fetch_array($resultComponentesExistentes))		
			{
			if ($strTripaComponentesExistentes)
				$strTripaComponentesExistentes .= '#'.$strCsTipoComponente.'#';
			$strTripaComponentesExistentes .= $rowComponentesExistentes['te_valor'];
			}

		// ==============================
		// Retiro as tags de aspas duplas
		// ==============================
		$strTripaComponentesExistentes    = str_replace('<AD>','',$strTripaComponentesExistentes);		
		$strTripaComponentesExistentesAux = $strTripaComponentesExistentes;				
		$arrComponentesExistentes 	      = explode('#'.$strCsTipoComponente.'#',$strTripaComponentesExistentes);

		// ===============================================================================================================================================
		// Verifico se houve ACR�SCIMO de componentes
		// ===============================================================================================================================================		
		$strTripaComponentesRecebidosAux = $strTripaComponentesRecebidos;
	
		for ($intContaComponentesExistentes = 0;$intContaComponentesExistentes < count($arrComponentesExistentes);$intContaComponentesExistentes++)
			$strTripaComponentesRecebidosAux = str_replace($arrComponentesExistentes[$intContaComponentesExistentes],'',$strTripaComponentesRecebidosAux);

		if ($strTripaComponentesRecebidosAux <> '' && $strTripaComponentesRecebidosAux <> '#'.$strCsTipoComponente.'#')
			$arrComponentesAcrescentados = explode('#'.$strCsTipoComponente.'#',$strTripaComponentesRecebidosAux);
		// ===============================================================================================================================================

		// ===============================================================================================================================================
		// Verifico se houve REMO��O de componentes
		// ===============================================================================================================================================		
		$strTripaComponentesExistentesAux = $strTripaComponentesExistentes;		
		for ($intContaComponentesRecebidos = 0;$intContaComponentesRecebidos < count($arrComponentesRecebidos);$intContaComponentesRecebidos++)
			$strTripaComponentesExistentesAux = str_replace($arrComponentesRecebidos[$intContaComponentesRecebidos],'',$strTripaComponentesExistentesAux);

		if ($strTripaComponentesExistentesAux <> '' && $strTripaComponentesExistentesAux <> '#'.$strCsTipoComponente.'#')
			$arrComponentesRemovidos = explode('#'.$strCsTipoComponente.'#',$strTripaComponentesExistentesAux);
		// ===============================================================================================================================================		
		
		}
	else
		$arrComponentesAcrescentados = $arrComponentesRecebidos;
		
	// ===============================
	// Acrescento os componentes novos
	// ===============================
	if (count($arrComponentesAcrescentados)>0)
		{
		$strTripaInsereComponentes = '';
		$strTripaACR			   = '';
		for ($intItemComponentesAcrescentados = 0;$intItemComponentesAcrescentados < count($arrComponentesAcrescentados);$intItemComponentesAcrescentados ++)
			{
			if ($arrComponentesAcrescentados[$intItemComponentesAcrescentados] <> '')
				{
				if ($strTripaInsereComponentes<>'')
					$strTripaInsereComponentes .= ',';
				$strTripaInsereComponentes .= '("'.$te_node_address.'",'.$arrSO['id_so'].',"'.$strCsTipoComponente.'","'.$arrComponentesAcrescentados[$intItemComponentesAcrescentados].'")';			

				// Somente retorno ACRESCENTADOS se j� houverem componentes registrados anteriormente
				if ($intTotalGeralExistentes > 0)			
					{
					if ($strTripaACR)
						$strTripaACR .= '#'.$strCsTipoComponente.'#';
					$strTripaACR .= $arrComponentesAcrescentados[$intItemComponentesAcrescentados];			
					}
				}
			}	
		if ($strTripaInsereComponentes)
			{
			$strQueryInsereComponente =  ' INSERT
										   INTO	 	componentes_estacoes(te_node_address,
																		  id_so,
																		  cs_tipo_componente,
																		  te_valor)
								   		   VALUES				'.$strTripaInsereComponentes;
			$resultInsereComponente = mysql_query($strQueryInsereComponente) or die('Problema Inserindo Dados na Tabela Componentes_Esta��es!');					
			}
		}
		
	// =============================================
	// Removo os componentes que n�o foram recebidos
	// =============================================
	if (count($arrComponentesRemovidos)>0)
		{
		$strTripaRemoveComponentes = '';
		$strTripaREM			   = '';
		for ($intItemComponentesRemovidos = 0;$intItemComponentesRemovidos < count($arrComponentesRemovidos);$intItemComponentesRemovidos ++)
			{
			if ($strTripaRemoveComponentes)
				$strTripaRemoveComponentes .= ',';
			$strTripaRemoveComponentes .= '"'.$arrComponentesRemovidos[$intItemComponentesRemovidos].'"';			

			if ($strTripaREM)
				$strTripaREM .= '#'.$strCsTipoComponente.'#';
			$strTripaREM .= $arrComponentesRemovidos[$intItemComponentesRemovidos];			
			}
			
		if ($strTripaRemoveComponentes)
			{
			$strQueryRemoveComponente =  ' DELETE
										   FROM	 	componentes_estacoes
										   WHERE	te_node_address = "'.$te_node_address.'" AND
										   			id_so = '.$arrSO['id_so'].' AND
													cs_tipo_componente = "'.$strCsTipoComponente.'" AND
													te_valor IN ('.$strTripaRemoveComponentes.')';
			$resultRemoveComponente = mysql_query($strQueryRemoveComponente) or die('Problema Removendo Dados na Tabela Componentes_Esta��es!');					
			}
		}

	/*
	// ===============================================================================================================================================
	// Verifico se houve apenas ALTERA��O de componentes
	// ===============================================================================================================================================		
	if ( count($arrComponentesAcrescentados) > 0 &&
	    (count($arrComponentesAcrescentados) == count($arrComponentesRemovidos)) &&
		 $strTripaComponentesRecebidosAux    <> '#'.$strCsTipoComponente.'#' && 
		 $strTripaComponentesExistentesAux   <> '#'.$strCsTipoComponente.'#')
		{
		// Neste caso, entendo que houve apenas uma altera��o e esvazio as tripas de ACR�SCIMO e REMO��O, informando apenas ALTERA��O.
		$strTripaACR	 = '';
		$strTripaREM	 = '';		
		$strTripaALT     = $strTripaComponentesRecebidosAux;
		$strTripaALT_OLD = $strTripaComponentesExistentesAux;			
		}
	// ===============================================================================================================================================				
	*/

	// =======================================================
	// Ser� retornado um array com os elementos:
	// =======================================================
	// ACR     => Acrescentados
	// REM     => Removidos
	// ALT     => Alterados
	// ALT_OLD => Registros Antigos, afetados pelas ALTERA��ES
	// =======================================================
	$arrRetorno = array('ACR' 	  => $strTripaACR, 
						'REM' 	  => $strTripaREM,
						'ALT' 	  => $strTripaALT, 
						'ALT_OLD' => $strTripaALT_OLD);													
	return $arrRetorno;
	}
?>