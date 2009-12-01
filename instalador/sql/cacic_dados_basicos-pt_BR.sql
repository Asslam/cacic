-- --------------------------------------------------------
-- Dados b�sicos para o banco de dados CACIC
-- SGBD: MySQL-5.0.51
-- phpMyAdmin SQL Dump
-- --------------------------------------------------------

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Extraindo dados da tabela `acoes`
--

INSERT INTO `acoes` (`id_acao`, `te_descricao_breve`, `te_descricao`, `te_nome_curto_modulo`, `dt_hr_alteracao`, `cs_situacao`) VALUES
('cs_auto_update', 'Auto Atualiza��o dos Agentes', 'Essa a��o permite que seja realizada a auto atualiza��o dos agentes do CACIC nos computadores onde os agentes s�o executados. \r\n\r\n', NULL, '0000-00-00 00:00:00', NULL),
('cs_coleta_compart', 'Coleta Informa��es de Compartilhamentos de Diret�rios e Impressoras', 'Essa a��o permite que sejam coletadas informa��es sobre compartilhamentos de diret�rios e impressoras dos computadores onde os agentes est�o instalados.', 'COMP', '0000-00-00 00:00:00', NULL),
('cs_coleta_hardware', 'Coleta Informa��es de Hardware', 'Essa a��o permite que sejam coletadas diversas informa��es sobre o hardware dos computadores onde os agentes est�o instalados, tais como Mem�ria, Placa de V�deo, CPU, Discos R�gidos, BIOS, Placa de Rede, Placa M�e, etc.', 'HARD', '0000-00-00 00:00:00', NULL),
('cs_coleta_monitorado', 'Coleta Informa��es sobre os Sistemas Monitorados', 'Essa a��o permite que sejam coletadas, nas esta��es onde os agentes Cacic est�o instalados, as informa��es acerca dos perfi�s de sistemas, previamente cadastrados pela Administra��o Central.', 'MONI', '0000-00-00 00:00:00', NULL),
('cs_coleta_officescan', 'Coleta Informa��es do Antiv�rus OfficeScan', 'Essa a��o permite que sejam coletadas informa��es sobre o antiv�rus OfficeScan nos computadores onde os agentes est�o instalados. S�o coletadas informa��es como a vers�o do engine, vers�o do pattern, ende�o do servidor, data da instala��o, etc.', 'ANVI', '0000-00-00 00:00:00', NULL),
('cs_coleta_patrimonio', 'Coleta Informa��es de Patrim�nio', 'Essa a��o permite que sejam coletadas diversas informa��es sobre Patrim�nio e Localiza��o F�sica dos computadores onde os agentes est�o instalados.', 'PATR', '0000-00-00 00:00:00', NULL),
('cs_coleta_software', 'Coleta Informa��es de Software', 'Essa a��o permite que sejam coletadas informa��es sobre as vers�es de diversos softwares instalados nos computadores onde os agentes s�o executados. S�o coletadas, por exemplo, informa��es sobre as vers�es do Internet Explorer, Mozilla, DirectX, ADO, BDE, DAO, Java Runtime Environment, etc.', 'SOFT', '0000-00-00 00:00:00', NULL),
('cs_coleta_unid_disc', 'Coleta Informa��es sobre Unidades de Disco', 'Essa a��o permite que sejam coletadas informa��es sobre as unidades de disco dispon�veis nos computadores onde os agentes s�o executados. S�o coletadas, por exemplo, informa��es sobre o sistema de arquivos das unidades, suas capacidades de armazenamento, ocupa��o, espa�o livre, etc.', 'UNDI', '0000-00-00 00:00:00', NULL),
('cs_suporte_remoto', 'Suporte Remoto Seguro', 'Esta a��o permite a realiza��o de suporte remoto na esta��o de trabalho, com registro de logs de sess�o efetuado pelo Gerente WEB.', 'SR_CACIC', '0000-00-00 00:00:00', NULL);

--
-- Extraindo dados da tabela `configuracoes_padrao`
--

INSERT INTO `configuracoes_padrao` (`in_exibe_erros_criticos`, `in_exibe_bandeja`, `nu_exec_apos`, `nu_rel_maxlinhas`, `nm_organizacao`, `nu_timeout_srcacic`, `nu_intervalo_exec`, `nu_intervalo_renovacao_patrim`, `te_senha_adm_agente`, `te_serv_updates_padrao`, `te_serv_cacic_padrao`, `te_enderecos_mac_invalidos`, `te_janelas_excecao`, `cs_abre_janela_patr`, `id_default_body_bgcolor`, `te_exibe_graficos`, `nu_porta_srcacic`, `nu_resolucao_grafico_h`, `nu_resolucao_grafico_w`) VALUES
('N', 'S', 10, 50, 'DATAPREV - Empresa de T.I. da Previd�ncia Social', 30, 4, 0, '5a584f8a61b65baf', '192.168.0.1', '192.168.0.1', '00-00-00-00-00-00,44-45-53-54-00-00,44-45-53-54-00-01,\r\n00-53-45-00-00-00,00-50-56-C0-00-01,00-50-56-C0-00-08', 'openoffice.org, microsoft word, photoshop, hod, aor.exe, pc2003.exe, cpp.exe, sal.exe, sal.bat, girafa4.exe, dro.exe, plenus', 'N', '#EBEBEB', '[so][acessos][acessos_locais][locais]', '5900', 0, 0);

--
-- Extraindo dados da tabela `descricao_hardware`
--

INSERT INTO `descricao_hardware` (`nm_campo_tab_hardware`, `te_desc_hardware`, `te_locais_notificacao_ativada`) VALUES
('qt_mem_ram', 'Mem�ria RAM', ',,12,'),
('qt_placa_video_cores', 'Qtd. Cores Placa V�deo', ','),
('qt_placa_video_mem', 'Mem�ria Placa V�deo', ',,1,'),
('te_bios_desc', 'Descri��o da BIOS', ',19,,1,'),
('te_bios_fabricante', 'Fabricante da BIOS', ',,1,'),
('te_cdrom_desc', 'CD-ROM', ','),
('te_cpu_desc', 'CPU', ',18,19,,12,'),
('te_cpu_fabricante', 'Fabricante da CPU', ',,1,'),
('te_cpu_serial', 'Serial da CPU', ','),
('te_mem_ram_desc', 'Descri��o da RAM', ',19,,1,'),
('te_modem_desc', 'Modem', ','),
('te_mouse_desc', 'Mouse', ''),
('te_placa_mae_desc', 'Placa M�e', ','),
('te_placa_mae_fabricante', 'Fabricante Placa M�e', ',,1,'),
('te_placa_rede_desc', 'Placa de Rede', ',,12,'),
('te_placa_som_desc', 'Placa de Som', ''),
('te_placa_video_desc', 'Placa de V�deo', ','),
('te_placa_video_resolucao', 'Resolu��o Placa de V�deo', ''),
('te_teclado_desc', 'Teclado', '');

--
-- Extraindo dados da tabela `descricoes_colunas_computadores`
--

INSERT INTO `descricoes_colunas_computadores` (`nm_campo`, `te_descricao_campo`, `cs_condicao_pesquisa`) VALUES
('dt_hr_coleta_forcada_estacao', 'Quant. dias de �ltima coleta for�ada na esta��o', 'S'),
('dt_hr_inclusao', 'Quant. dias de inclus�o do computador na base', 'S'),
('dt_hr_ult_acesso', 'Quant. dias do �ltimo acesso da esta��o ao gerente WEB', 'S'),
('id_ip_rede', 'Endere�o IP da Subrede', 'S'),
('id_so', 'C�digo do sistema operacional da esta��o', 'S'),
('qt_mem_ram', 'Quant. mem�ria RAM', 'S'),
('qt_placa_video_cores', 'Quant. cores da placa de v�deo', 'S'),
('qt_placa_video_mem', 'Quant. mem�ria da placa de v�deo', 'S'),
('te_bios_data', 'Identifica��o da BIOS', 'S'),
('te_bios_desc', 'Descri��o da BIOS', 'S'),
('te_bios_fabricante', 'Nome do fabricante da BIOS', 'S'),
('te_cdrom_desc', 'Unidade de Disco �tico', 'S'),
('te_cpu_desc', 'CPU', 'S'),
('te_cpu_fabricante', 'Fabricante da CPU', 'S'),
('te_cpu_frequencia', 'Frequ�ncia da CPU', 'S'),
('te_cpu_serial', 'N�mero de s�rie da CPU', 'S'),
('te_dns_primario', 'IP do DNS prim�rio', 'S'),
('te_dns_secundario', 'IP do DNS secund�rio', 'S'),
('te_dominio_dns', 'Nome/IP do dom�nio DNS', 'S'),
('te_dominio_windows', 'Nome/IP do dom�nio Windows', 'S'),
('te_gateway', 'IP do gateway', 'S'),
('te_ip', 'IP da esta��o', 'S'),
('te_mascara', 'M�scara de Subrede', 'S'),
('te_mem_ram_desc', 'Descri��o da mem�ria RAM', 'S'),
('te_modem_desc', 'Descri��o do modem', 'S'),
('te_mouse_desc', 'Descri��o do mouse', 'S'),
('te_node_address', 'Endere�o MAC da esta��o', 'S'),
('te_nomes_curtos_modulos', 'te_nomes_curtos_modulos', 'N'),
('te_nome_computador', 'Nome do computador', 'S'),
('te_nome_host', 'Nome do Host', 'S'),
('te_origem_mac', 'te_origem_mac', 'N'),
('te_placa_mae_desc', 'Placa-M�e', 'S'),
('te_placa_mae_fabricante', 'Fabricante da placa-mãe', 'S'),
('te_placa_rede_desc', 'Placa de Rede', 'S'),
('te_placa_som_desc', 'Placa de Som', 'S'),
('te_placa_video_desc', 'Placa de V�deo', 'S'),
('te_placa_video_resolucao', 'Resolu��o da placa de v�deo', 'S'),
('te_serv_dhcp', 'IP do servidor DHCP', 'S'),
('te_so', 'Identificador Interno do S.O.', 'S'),
('te_teclado_desc', 'Descri��o do teclado', 'S'),
('te_versao_cacic', 'Vers�o do Agente Principal do CACIC', 'S'),
('te_versao_gercols', 'Vers�o do Gerente de Coletas do CACIC', 'S'),
('te_wins_primario', 'IP do servidor WINS prim�rio', 'S'),
('te_wins_secundario', 'IP do servidor WINS secund�rio', 'S'),
('te_workgroup', 'Nome do grupo de trabalho', 'S');

--
-- Extraindo dados da tabela `grupo_usuarios`
--

INSERT INTO `grupo_usuarios` (`id_grupo_usuarios`, `te_grupo_usuarios`, `te_menu_grupo`, `te_descricao_grupo`, `cs_nivel_administracao`, `nm_grupo_usuarios`) VALUES
(1, 'Comum', 'menu_com.txt', 'Usu�rio limitado, sem acesso a informa��es confidenciais como Softwares Inventariados e Op��es Administrativas como For�ar Coletas e Excluir Computadores. Poder� alterar sua pr�pria senha.', 0, ''),
(2, 'Administra��o', 'menu_adm.txt', 'Acesso irrestrito.', 1, ''),
(5, 'Gest�o Central', 'menu_adm.txt', 'Acesso de leitura em todas as op��es.', 2, ''),
(6, 'Supervis�o', 'menu_sup.txt', 'Manuten��o de tabelas e acesso a todas as informa��es referentes � Localiza��o.', 3, ''),
(7, 'T�cnico', 'menu_tec.txt', 'Acesso t�cnico. Ser� permitido acessar configura��es de rede e relat�rios de Patrim�nio e Hardware.', 0, '');

--
-- Extraindo dados da tabela `perfis_aplicativos_monitorados`
--

INSERT INTO `perfis_aplicativos_monitorados` (`id_aplicativo`, `nm_aplicativo`, `cs_car_inst_w9x`, `te_car_inst_w9x`, `cs_car_ver_w9x`, `te_car_ver_w9x`, `cs_car_inst_wnt`, `te_car_inst_wnt`, `cs_car_ver_wnt`, `te_car_ver_wnt`, `cs_ide_licenca`, `te_ide_licenca`, `dt_atualizacao`, `te_arq_ver_eng_w9x`, `te_arq_ver_pat_w9x`, `te_arq_ver_eng_wnt`, `te_arq_ver_pat_wnt`, `te_dir_padrao_w9x`, `te_dir_padrao_wnt`, `id_so`, `te_descritivo`, `in_disponibiliza_info`, `in_disponibiliza_info_usuario_comum`, `dt_registro`) VALUES
(20, 'Windows XP Professional', '0', '', '0', '', '0', '', '0', '', '1', 'HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\ProductId', '2009-07-22 16:00:09', '', '', '', '', '', '', 20, '', 'S', 'N', NULL),
(67, 'CACIC - Col_Anvi - Col. de Inf. de Anti-V�rus', '0', '', '0', 'Cacic\\modulos\\col_anvi.exe', '0', '', '0', 'Cacic\\modulos\\col_anvi.exe', '0', '', '2009-07-21 18:22:13', '', '', '', '', '', '', 0, '', 'N', 'N', NULL),
(68, 'CACIC - Col_Moni - Col. de Inf. de Sistemas Monitorados', '0', '', '0', 'cacic\\modulos\\col_moni.exe', '0', '', '0', 'cacic\\modulos\\col_moni.exe', '0', '', '2009-07-21 18:22:49', '', '', '', '', '', '', 0, '', 'N', 'N', NULL),
(69, 'CACIC - Col_Patr - Col. de Inf. de Patrim�nio e Loc. F�sica', '', '', '', 'cacic\\modulos\\col_patr.exe', '', '', '', 'cacic\\modulos\\col_patr.exe', '', '', '2008-06-04 11:11:55', '', '', '', '', '', '', 0, '', '', '', NULL),
(70, 'CACIC - Col_Hard - Col. de Inf. de Hardware', '0', '', '0', 'cacic\\modulos\\col_hard.exe', '0', '', '0', 'cacic\\modulos\\col_hard.exe', '0', '', '2009-07-21 18:22:34', '', '', '', '', '', '', 0, '', 'N', 'N', NULL),
(71, 'CACIC - Col_Soft - Col. de Inf. de Softwares B�sicos', '', '', '', 'cacic\\modulos\\col_soft.exe', '', '', '', 'cacic\\modulos\\col_soft.exe', '', '', '2008-05-23 15:02:41', '', '', '', '', '', '', 0, '', '', '', NULL),
(72, 'CACIC - Col_Undi - Col. de Inf. de Unidades de Disco', '', '', '', 'cacic\\modulos\\col_undi.exe', '', '', '', 'cacic\\modulos\\col_undi.exe', '', '', '2008-05-23 15:02:59', '', '', '', '', '', '', 0, '', '', '', NULL),
(73, 'CACIC - Col_Comp - Col. de Inf. de Compartilhamentos', '0', '', '0', 'cacic\\modulos\\col_comp.exe', '0', '', '0', 'cacic\\modulos\\col_comp.exe', '0', '', '2009-07-21 18:22:24', '', '', '', '', '', '', 0, '', 'N', 'N', NULL),
(74, 'CACIC - Ini_Cols - Inicializador de Coletas', '', '', '', 'cacic\\modulos\\ini_cols.exe', '', '', '', 'cacic\\modulos\\ini_cols.exe', '', '', '2008-06-04 11:12:54', '', '', '', '', '', '', 0, '', '', '', NULL),
(75, 'CACIC - Agente Principal', '0', '', '4', 'Cacic\\cacic2.exe', '0', '', '4', 'Cacic\\cacic2.exe', '0', '', '2009-07-22 12:36:23', '', '', '', '', '', '', 0, '', 'S', 'S', NULL),
(76, 'CACIC - Gerente de Coletas', '0', '', '4', 'Cacic\\modulos\\ger_cols.exe', '0', '', '4', 'Cacic\\modulos\\ger_cols.exe', '0', '', '2009-07-22 12:36:37', '', '', '', '', '', '', 0, '', 'S', 'S', NULL),
(77, 'TrendMicro OfficeScan - PATTERN', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\InternalPatternVer', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\InternalPatternVer', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\InternalPatternVer', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\InternalPatternVer', '0', '', '2008-03-03 15:49:34', '', '', '', '', '', '', 0, '', 'N', 'S', NULL),
(78, 'TrendMicro OfficeScan - ENGINE', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '0', '', '2008-03-03 15:47:44', '', '', '', '', '', '', 0, '', 'N', 'S', NULL),
(79, 'TrendMicro OfficeScan - DATA DE INSTALA��O', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\InstDate', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\InstDate', '0', '', '2008-03-05 15:44:00', '', '', '', '', '', '', 0, '', 'N', 'S', NULL),
(80, 'TrendMicro OfficeScan - SERVIDOR', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Server', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Misc.\\VsApiNT-Ver', '2', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\TrendMicro\\PC-cillinNTCorp\\CurrentVersion\\Server', '0', '', '2008-03-05 15:47:36', '', '', '', '', '', '', 0, '', 'N', 'S', NULL),
(81, 'Microsoft Outlook', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\App Paths\\OUTLOOK.EXE\\Path', '0', '', '3', 'HKEY_LOCAL_MACHINE\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\App Paths\\OUTLOOK.EXE\\Path', '0', '', '0', '', '2008-09-11 18:47:24', '', '', '', '', '', '', 0, '', 'N', 'S', NULL),
(82, 'Windows 2007', '0', '', '0', '', '0', '', '0', '', '1', 'HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\ProductId', '2009-07-22 16:01:40', '', '', '', '', '', '', 28, '', 'N', 'N', NULL),
(83, '�ltima Execu��o do MapaCACIC', '0', '', '1', 'Cacic\\MapaCACIC.log', '0', '', '1', 'Cacic\\MapaCACIC.log', '0', '', '2009-07-31 11:39:08', '', '', '', '', '', '', 0, '', 'S', 'S', NULL),
(84, 'CACIC - M�dulo para Suporte Remoto Seguro', '1', 'Cacic\\Modulos\\srcacicsrv.exe', '4', 'Cacic\\Modulos\\srcacicsrv.exe', '1', 'Cacic\\Modulos\\srcacicsrv.exe', '4', 'Cacic\\Modulos\\srcacicsrv.exe', '0', '', '2009-11-12 16:21:11', '', '', '', '', '', '', 0, '', 'S', 'S', NULL);

--
-- Extraindo dados da tabela `so`
--

INSERT INTO `so` (`id_so`, `te_desc_so`, `sg_so`, `te_so`, `in_mswindows`) VALUES
(20, 'Windows XP Professional', 'WXP_PRO', '2.5.1.1.256', 'S'),
(21, 'Windows 95 SP1', 'W95_SP1', '1.4.0.B', 'S'),
(22, 'Ubuntu 9.04 Jaunty Jackalope', 'Ubuntu-9.04', 'Ubuntu - 9.04', 'N'),
(27, 'Debian 5.0.1 Lenny', 'Debian_501', 'Debian - 5.0.1', 'N'),
(28, 'Windows 2007', 'W2K7', '2.6.1.1.256', 'S'),
(29, 'Ubuntu 8.10 Intrepid Ibex', 'Ubuntu-8.10', 'Ubuntu - 8.10', 'N'),
(31, 'Windows Vista', 'WVista', '2.6.0.1.256', 'S'),
(32, 'Windows 2000 Professional', 'W2K_PRO', '2.5.0.1.0', 'S'),
(33, 'Debian 5.0.3 Lenny', 'Debian_503', 'Debian - 5.0.3', 'N'),
(34, 'Ubuntu 9.10 Karmic Koala', 'Ubuntu_910', 'Ubuntu - 9.10', 'N');

--
-- Extraindo dados da tabela `tipos_software`
--

INSERT INTO `tipos_software` (`id_tipo_software`, `te_descricao_tipo_software`) VALUES
(1, 'Vers�o Trial'),
(2, 'Corre��o/Atualiza��o'),
(3, 'Sistema Interno'),
(4, 'Software Livre'),
(5, 'Software Licenciado'),
(6, 'Software Suspeito'),
(7, 'Software Descontinuado'),
(8, 'Jogos e Similares');

--
-- Extraindo dados da tabela `tipos_unidades_disco`
--

INSERT INTO `tipos_unidades_disco` (`id_tipo_unid_disco`, `te_tipo_unid_disco`) VALUES
('1', 'Remov�vel'),
('2', 'Disco R�gido'),
('3', 'CD-ROM'),
('4', 'Unid.Remota');
