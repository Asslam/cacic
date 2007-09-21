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
$v_versao = '2.2.3-RC4';
/* 
2.2.3-RC4   (Anderson Peterle - Dataprev/ES - Julho a Setembro/2007)
		  + Implementado o destaque de a��es dos usu�rios: INS->Verde UPD->Amarelo DEL->Vermelho
		  + Implementado o detalhamento dos dados constantes dos detalhes das estat�sticas da p�gina inicial
		  + Implementada a op��o "Administra��o/Configurar Gerente/Exibir Gr�ficos na P�gina Principal e Detalhes" para exibi��o de pizza ou tabela
		  + Implementada a manuten��o do cadastro sistemas operacionais em "Administra��o/Cadastros/S.Operacionais"
		  + Implementada a ordena��o por colunas nas op��es "Administra��o/Cadastros/Locais", "Administra��o/Cadastros/SubRedes", "Administra��o/Cadastros/Usu�rios" e "Administra��o/Cadastros/S.Operacionais"
		  * Efetuadas corre��es em consultas e atualiza��es de informa��es do banco de dados
		  		  		  
2.2.3-dev-1 (Anderson Peterle - Dataprev/ES - Junho/2007)
		  * Corrigido o processo de libera��o de FTP, onde a tabela redes_grupos_ftp � liberada ap�s a opera��o
			de transfer�ncia de arquivos por parte do m�dulo cliente Gerente de Coletas.

2.2.3-dev (Anderson Peterle - Dataprev/ES - Maio/2007)
		  + Implementado o detalhamento para as estat�sticas exibidas na p�gina principal quando representarem
		  mais de um local (local prim�rio + local(is) secund�rio(s))
		  + Os n�veis Administra��o e Gest�o Central tamb�m acessam a op��o de detalhamento.

2.2.3     (Anderson Peterle - Dataprev/ES - Mar�o e Abril/2007)
		  + Implementada a op��o de sele��o de "Locais Secund�rios" nas janelas de inclus�o e detalhes de usu�rios,
		    para simula��o de pseudo "rela��o de confian�a" entre usu�rios e locais, possibilitando a estes usu�rios 
		    o acesso e manipula��o das informa��es dos locais "confiantes";
		  + Adequa��o das consultas ao conceito de "rela��o de confian�a" implementado.		  

2.2.2     (Anderson Peterle - Dataprev/ES - Fevereiro/2007)
		  * Corrigida a atribui��o indevida do nome de usu�rio constande de resultado de Log de Atividades ao nome do usu�rio logado na aplica��o;
		  * Corrigidas algumas correla��es de "local" em consultas realizadas por usu�rios com n�veis diferentes de "Administra��o" e "Gest�o Central";
		  + Implementada a op��o de sele��o de Coletas de Sistemas Monitorados quando do cadastramento da subrede;
		  + Implementada a op��o de sele��o/altera��o de Coletas de Sistemas Monitorados quando da edi��o de configura��es da subrede.

2.2.1     (Anderson Peterle - Dataprev/ES - Janeiro/2007)
		  Efetuadas adapta��es para suporte a base centralizada de dados, quando as subredes cadastradas 
   		  passam a fazer parte de uma "localiza��o" ou "local".
		  As adapta��es impactaram na defini��o dos seguintes n�veis de acesso:
		  1) Administra��o => Acesso irrestrito, com vis�o total de todos os dados de todos os "locais".
		  					  Tem total permiss�o para altera��o de dados constantes de tabelas centralizadas;
		  2) Gest�o Central=> Acesso irrestrito, com vis�o total de todos os dados de todos os "locais".
							  N�o tem permiss�o para altera��o de dados constantes de tabelas centralizadas;
		  3) Supervisor	 =>   Acesso restrito aos dados do "local" de cadastro. Seu cadastro � realizado pelo n�vel "Administra��o";
							  Tem permiss�o para vis�o/altera��o de dados locais e cadastramento de usu�rios
		 					  de n�veis "T�cnico" ou "Comum";
		  4) T�cnico	 =>   Acesso restrito aos dados do "local" de cadastro. Seu cadastro � realizado pelo n�vel "Supervis�o".
							  Tem permiss�o para acesso a configuracoes de rede e relat�rios de Patrim�nio e Hardware;
		  5) Comum		 =>   Acesso restrito aos dados do "local" de cadastro. Seu cadastro � realizado pelo n�vel "Supervis�o".
							  N�o tem acesso a informa��es "confidenciais" como Softwares Inventariados e Op��es Administrativas 
							  como For�ar Coletas e Excluir Computador. Poder� alterar sua pr�pria senha.		
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Topo</title></head>
<?
echo '<body bgcolor='.($_SESSION['id_default_body_bgcolor']<>''?$_SESSION['id_default_body_bgcolor']:'#EBEBEB').' leftmargin="1" topmargin="0">';	
?>
<SCRIPT language=JavaScript>
<!--
function scrollit(seed) 
	{
	var msg="*** CACIC - Configurador Autom�tico e Coletor de Informa��es Computacionais ***";
	var out = " ";
	var c = 1;
	if (seed > 100) 
		{
		seed--;
		cmd="scrollit("+seed+")";
		timerTwo=window.setTimeout(cmd,100);
		}
	else if (seed <= 100 && seed > 0) 
		{
		for (c=0 ; c < seed ; c++) 
			{
			out+=" ";
			}
		out+=msg;
		seed--;
		window.status=out;
		cmd="scrollit("+seed+")";
		timerTwo=window.setTimeout(cmd,100);
		}
	else if (seed <= 0) 
		{
		if (-seed < msg.length) 
			{
			out+=msg.substring(-seed,msg.length);
			seed--;
			window.status=out;
			cmd="scrollit("+seed+")";
			timerTwo=window.setTimeout(cmd,100);
			}
		else 
			{
			window.status=" ";
			timerTwo=window.setTimeout("scrollit(100)",75);
			}
		}
	}
//scrollit(100);
</SCRIPT>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5">&nbsp;</td>
          <td><strong><font size="5" face="Verdana, Arial, Helvetica, sans-serif"><img src="imgs/cacic_logo.png" width="50" height="50"></font></strong></td>
          <td><table width="75%" border="0">
              <tr>
                <td><img src="imgs/cacic_tit.gif"></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">v.<? echo $v_versao;?></font></div></td>
              </tr>
            </table>
            
          </td>
          <td><table border="0" align="right" cellpadding="0" cellspacing="0">
              <tr> 
                <td><img src="imgs/cacic_ext.gif" align="bottom"></td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td><div align="right"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
				<? 
				if ($_SESSION['nm_local'])
					echo $_SESSION['nm_local']; 					
				else 
					{
					require_once('include/library.php');					
					echo get_valor_campo('configuracoes_padrao', 'nm_organizacao'); 
					}				
				?>
				</font></b></div></td>
                <td>&nbsp;&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="2" background="imgs/linha_h.gif"></td>
  </tr>
</table>
</body>
</html>