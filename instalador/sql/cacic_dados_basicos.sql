-- --------------------------------------------------------
-- Dados basicos para o banco de dados CACIC 2.2.2
-- SGBD: MySQL-4.1.20
-- --------------------------------------------------------
--
-- Dumping data for table `acoes`
--


/*!40000 ALTER TABLE `acoes` DISABLE KEYS */;
LOCK TABLES `acoes` WRITE;
INSERT INTO `acoes` VALUES ('cs_auto_update','Auto Atualiza��o dos Agentes','Essa a��o permite que seja realizada a auto atualiza��o dos agentes do CACIC nos computadores onde os agentes s�o executados. \r\n\r\n',NULL,'0000-00-00 00:00:00',NULL),('cs_coleta_compart','Coleta Informa��es de Compartilhamentos de Diret�rios e Impressoras','Essa a��o permite que sejam coletadas informa��es sobre compartilhamentos de diret�rios e impressoras dos computadores onde os agentes est�o instalado.','COMP','0000-00-00 00:00:00',NULL),('cs_coleta_hardware','Coleta Informa��es de Hardware','Essa a��o permite que sejam coletadas diversas informa��es sobre o hardware dos computadores onde os agentes est�o instalados, tais como Mem�ria, Placa de V�deo, CPU, Discos R�gidos, BIOS, Placa de Rede, Placa M�e, etc.','HARD','0000-00-00 00:00:00',NULL),('cs_coleta_monitorado','Coleta Informa��es sobre os Sistemas Monitorados','Essa a��o permite que sejam coletadas, nas esta��es onde os agentes Cacic est�o instalados, as informa��es acerca dos perfís de sistemas, previamente cadastrados pela Administra��o Central.','MONI','0000-00-00 00:00:00',NULL),('cs_coleta_officescan','Coleta Informa��es do Antiv�rus OfficeScan','Essa a��o permite que sejam coletadas informa��es sobre o anti-v�rus OfficeScan nos computadores onde os agentes est�o instalado. S�o coletadas informa��es como a vers�o do engine, vers�o do pattern, endere�o do servidor, data da instala��o, etc.','ANVI','0000-00-00 00:00:00',NULL),('cs_coleta_patrimonio','Coleta Informa��es de Patrim�nio','Essa a��o permite que sejam coletadas diversas informa��es sobre Patrim�nio e Localiza��o F�sica dos computadores onde os agentes est�o instalados.','PATR','0000-00-00 00:00:00',NULL),('cs_coleta_software','Coleta Informa��es de Software','Essa a��o permite que sejam coletadas informa��es sobre a vers�o de diversos softwares instalados nos computadores onde os agentes s�o executados. S�o coletadas, por exemplo, informa��es sobre as vers�es do Internet Explorer, Mozilla, DirectX, ADO, BDE, DAO, Java Runtime Environment, etc.','SOFT','0000-00-00 00:00:00',NULL),('cs_coleta_unid_disc','Coleta Informa��es sobre Unidades de Disco','Essa a��o permite que sejam coletadas informa��es sobre as unidades de disco dispon�veis nos computadores onde os agentes s�o executados. S�o coletadas, por exemplo, informa��es sobre o sistema de arquivos das unidades, suas capacidades de armazenamento, ocupa��o, espa�o livre, etc.','UNDI','0000-00-00 00:00:00',NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `acoes` ENABLE KEYS */;

--
-- Dumping data for table `acoes_so`
--


/*!40000 ALTER TABLE `acoes_so` DISABLE KEYS */;
LOCK TABLES `acoes_so` WRITE;
INSERT INTO `acoes_so` VALUES (2,'cs_auto_update',0),(1,'cs_auto_update',1),(2,'cs_auto_update',1),(1,'cs_auto_update',2),(2,'cs_auto_update',2),(1,'cs_auto_update',3),(2,'cs_auto_update',3),(1,'cs_auto_update',4),(2,'cs_auto_update',4),(1,'cs_auto_update',5),(2,'cs_auto_update',5),(1,'cs_auto_update',6),(2,'cs_auto_update',6),(1,'cs_auto_update',7),(2,'cs_auto_update',7),(1,'cs_auto_update',8),(2,'cs_auto_update',8),(1,'cs_auto_update',9),(2,'cs_auto_update',9),(1,'cs_auto_update',10),(2,'cs_auto_update',10),(1,'cs_auto_update',11),(2,'cs_auto_update',11),(1,'cs_auto_update',12),(2,'cs_auto_update',12),(2,'cs_auto_update',13),(2,'cs_coleta_compart',0),(1,'cs_coleta_compart',1),(2,'cs_coleta_compart',1),(1,'cs_coleta_compart',2),(2,'cs_coleta_compart',2),(1,'cs_coleta_compart',3),(2,'cs_coleta_compart',3),(1,'cs_coleta_compart',4),(2,'cs_coleta_compart',4),(1,'cs_coleta_compart',5),(2,'cs_coleta_compart',5),(1,'cs_coleta_compart',6),(2,'cs_coleta_compart',6),(1,'cs_coleta_compart',7),(2,'cs_coleta_compart',7),(1,'cs_coleta_compart',8),(2,'cs_coleta_compart',8),(1,'cs_coleta_compart',9),(2,'cs_coleta_compart',9),(1,'cs_coleta_compart',10),(2,'cs_coleta_compart',10),(1,'cs_coleta_compart',11),(2,'cs_coleta_compart',11),(1,'cs_coleta_compart',12),(2,'cs_coleta_compart',12),(1,'cs_coleta_compart',13),(2,'cs_coleta_compart',13),(2,'cs_coleta_hardware',0),(1,'cs_coleta_hardware',1),(2,'cs_coleta_hardware',1),(1,'cs_coleta_hardware',2),(2,'cs_coleta_hardware',2),(1,'cs_coleta_hardware',3),(2,'cs_coleta_hardware',3),(1,'cs_coleta_hardware',4),(2,'cs_coleta_hardware',4),(1,'cs_coleta_hardware',5),(2,'cs_coleta_hardware',5),(1,'cs_coleta_hardware',6),(2,'cs_coleta_hardware',6),(1,'cs_coleta_hardware',7),(2,'cs_coleta_hardware',7),(1,'cs_coleta_hardware',8),(2,'cs_coleta_hardware',8),(1,'cs_coleta_hardware',9),(2,'cs_coleta_hardware',9),(1,'cs_coleta_hardware',10),(2,'cs_coleta_hardware',10),(1,'cs_coleta_hardware',11),(2,'cs_coleta_hardware',11),(1,'cs_coleta_hardware',12),(2,'cs_coleta_hardware',12),(1,'cs_coleta_hardware',13),(2,'cs_coleta_hardware',13),(2,'cs_coleta_monitorado',0),(1,'cs_coleta_monitorado',1),(2,'cs_coleta_monitorado',1),(1,'cs_coleta_monitorado',2),(2,'cs_coleta_monitorado',2),(1,'cs_coleta_monitorado',3),(2,'cs_coleta_monitorado',3),(1,'cs_coleta_monitorado',4),(2,'cs_coleta_monitorado',4),(1,'cs_coleta_monitorado',5),(2,'cs_coleta_monitorado',5),(1,'cs_coleta_monitorado',6),(2,'cs_coleta_monitorado',6),(1,'cs_coleta_monitorado',7),(2,'cs_coleta_monitorado',7),(1,'cs_coleta_monitorado',8),(2,'cs_coleta_monitorado',8),(1,'cs_coleta_monitorado',9),(2,'cs_coleta_monitorado',9),(1,'cs_coleta_monitorado',10),(2,'cs_coleta_monitorado',10),(1,'cs_coleta_monitorado',11),(2,'cs_coleta_monitorado',11),(1,'cs_coleta_monitorado',12),(2,'cs_coleta_monitorado',12),(1,'cs_coleta_monitorado',13),(2,'cs_coleta_monitorado',13),(2,'cs_coleta_officescan',0),(1,'cs_coleta_officescan',1),(2,'cs_coleta_officescan',1),(1,'cs_coleta_officescan',2),(2,'cs_coleta_officescan',2),(1,'cs_coleta_officescan',3),(2,'cs_coleta_officescan',3),(1,'cs_coleta_officescan',4),(2,'cs_coleta_officescan',4),(1,'cs_coleta_officescan',5),(2,'cs_coleta_officescan',5),(1,'cs_coleta_officescan',6),(2,'cs_coleta_officescan',6),(1,'cs_coleta_officescan',7),(2,'cs_coleta_officescan',7),(1,'cs_coleta_officescan',8),(2,'cs_coleta_officescan',8),(1,'cs_coleta_officescan',9),(2,'cs_coleta_officescan',9),(1,'cs_coleta_officescan',10),(2,'cs_coleta_officescan',10),(1,'cs_coleta_officescan',11),(2,'cs_coleta_officescan',11),(1,'cs_coleta_officescan',12),(2,'cs_coleta_officescan',12),(1,'cs_coleta_officescan',13),(2,'cs_coleta_officescan',13),(2,'cs_coleta_patrimonio',0),(1,'cs_coleta_patrimonio',1),(2,'cs_coleta_patrimonio',1),(1,'cs_coleta_patrimonio',2),(2,'cs_coleta_patrimonio',2),(1,'cs_coleta_patrimonio',3),(2,'cs_coleta_patrimonio',3),(1,'cs_coleta_patrimonio',4),(2,'cs_coleta_patrimonio',4),(1,'cs_coleta_patrimonio',5),(2,'cs_coleta_patrimonio',5),(1,'cs_coleta_patrimonio',6),(2,'cs_coleta_patrimonio',6),(1,'cs_coleta_patrimonio',7),(2,'cs_coleta_patrimonio',7),(1,'cs_coleta_patrimonio',8),(2,'cs_coleta_patrimonio',8),(1,'cs_coleta_patrimonio',9),(2,'cs_coleta_patrimonio',9),(1,'cs_coleta_patrimonio',10),(2,'cs_coleta_patrimonio',10),(1,'cs_coleta_patrimonio',11),(2,'cs_coleta_patrimonio',11),(1,'cs_coleta_patrimonio',12),(2,'cs_coleta_patrimonio',12),(1,'cs_coleta_patrimonio',13),(2,'cs_coleta_patrimonio',13),(2,'cs_coleta_software',0),(1,'cs_coleta_software',1),(2,'cs_coleta_software',1),(1,'cs_coleta_software',2),(2,'cs_coleta_software',2),(1,'cs_coleta_software',3),(2,'cs_coleta_software',3),(1,'cs_coleta_software',4),(2,'cs_coleta_software',4),(1,'cs_coleta_software',5),(2,'cs_coleta_software',5),(1,'cs_coleta_software',6),(2,'cs_coleta_software',6),(1,'cs_coleta_software',7),(2,'cs_coleta_software',7),(1,'cs_coleta_software',8),(2,'cs_coleta_software',8),(1,'cs_coleta_software',9),(2,'cs_coleta_software',9),(1,'cs_coleta_software',10),(2,'cs_coleta_software',10),(1,'cs_coleta_software',11),(2,'cs_coleta_software',11),(1,'cs_coleta_software',12),(2,'cs_coleta_software',12),(1,'cs_coleta_software',13),(2,'cs_coleta_software',13),(2,'cs_coleta_unid_disc',0),(1,'cs_coleta_unid_disc',1),(2,'cs_coleta_unid_disc',1),(1,'cs_coleta_unid_disc',2),(2,'cs_coleta_unid_disc',2),(1,'cs_coleta_unid_disc',3),(2,'cs_coleta_unid_disc',3),(1,'cs_coleta_unid_disc',4),(2,'cs_coleta_unid_disc',4),(1,'cs_coleta_unid_disc',5),(2,'cs_coleta_unid_disc',5),(1,'cs_coleta_unid_disc',6),(2,'cs_coleta_unid_disc',6),(1,'cs_coleta_unid_disc',7),(2,'cs_coleta_unid_disc',7),(1,'cs_coleta_unid_disc',8),(2,'cs_coleta_unid_disc',8),(1,'cs_coleta_unid_disc',9),(2,'cs_coleta_unid_disc',9),(1,'cs_coleta_unid_disc',10),(2,'cs_coleta_unid_disc',10),(1,'cs_coleta_unid_disc',11),(2,'cs_coleta_unid_disc',11),(1,'cs_coleta_unid_disc',12),(2,'cs_coleta_unid_disc',12),(1,'cs_coleta_unid_disc',13),(2,'cs_coleta_unid_disc',13);
UNLOCK TABLES;
/*!40000 ALTER TABLE `acoes_so` ENABLE KEYS */;

--
-- Dumping data for table `configuracoes_locais`
--

/*!40000 ALTER TABLE `configuracoes_locais` DISABLE KEYS */;
LOCK TABLES `configuracoes_locais` WRITE;
INSERT INTO `configuracoes_locais` VALUES (1,NULL,'N','S',10,NULL,'0000-00-00 00:00:00',NULL,NULL,NULL,NULL,4,0,'','','','00-00-00-00-00-00,44-45-53-54-00-00,44-45-53-54-00-01,\r\n00-53-45-00-00-00,00-50-56-C0-00-01,00-50-56-C0-00-08',NULL,NULL,'N','#EBEBEB');
UNLOCK TABLES;
/*!40000 ALTER TABLE `configuracoes_locais` ENABLE KEYS */;

--
-- Dumping data for table `configuracoes_padrao`
--


/*!40000 ALTER TABLE `configuracoes_padrao` DISABLE KEYS */;
LOCK TABLES `configuracoes_padrao` WRITE;
INSERT INTO `configuracoes_padrao` VALUES ('N','S',0,'',0,0,'','','','00-00-00-00-00-00,44-45-53-54-00-00,44-45-53-54-00-01,\r\n00-53-45-00-00-00,00-50-56-C0-00-01,00-50-56-C0-00-08','','N','#EBEBEB');
UNLOCK TABLES;
/*!40000 ALTER TABLE `configuracoes_padrao` ENABLE KEYS */;


--
-- Dumping data for table `descricao_hardware`
--


/*!40000 ALTER TABLE `descricao_hardware` DISABLE KEYS */;
LOCK TABLES `descricao_hardware` WRITE;
INSERT INTO `descricao_hardware` VALUES (' te_cdrom_desc','CD-ROM','1'),('qt_mem_ram','Mem�ria RAM','1'),('qt_placa_video_cores','Qtd. Cores Placa V�deo','0'),('qt_placa_video_mem','Mem�ria Placa V�deo','0'),('te_bios_desc','Descri��o da BIOS','1'),('te_bios_fabricante','Fabricante da BIOS','0'),('te_cpu_desc','CPU','0'),('te_cpu_fabricante','Fabricante da CPU','0'),('te_cpu_serial','Serial da CPU','1'),('te_mem_ram_desc','Descri��o da RAM','0'),('te_modem_desc','Modem','0'),('te_mouse_desc','Mouse','1'),('te_placa_mae_desc','Placa M�e','1'),('te_placa_mae_fabricante','Fabricante Placa M�e','0'),('te_placa_rede_desc','Placa de Rede','1'),('te_placa_som_desc','Placa de Som','1'),('te_placa_video_desc','Placa de V�deo','1'),('te_placa_video_resolucao','Resolu��o Placa de V�deo','0'),('te_teclado_desc','Teclado','1');
UNLOCK TABLES;
/*!40000 ALTER TABLE `descricao_hardware` ENABLE KEYS */;

--
-- Dumping data for table `descricoes_colunas_computadores`
--


/*!40000 ALTER TABLE `descricoes_colunas_computadores` DISABLE KEYS */;
LOCK TABLES `descricoes_colunas_computadores` WRITE;
INSERT INTO descricoes_colunas_computadores VALUES ('dt_hr_coleta_forcada_estacao', 'Quant. dias da �ltima coleta for�ada na esta��o', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('dt_hr_inclusao', 'Quant. dias de inclus�o do computador na base', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('dt_hr_ult_acesso', 'Quant. dias do �ltimo acesso da esta��o ao gerente WEB', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('id_ip_rede', 'Endere�o IP da Subrede', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('id_so', 'C�digo do sistema operacional da esta��o', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('qt_mem_ram', 'Quant. mem�ria RAM', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('qt_placa_video_cores', 'Quant. cores da placa de v�deo', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('qt_placa_video_mem', 'Quant. mem�ria da placa de v�deo', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_bios_data', 'Identifica��o da BIOS', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_bios_desc', 'Descri��o da BIOS', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_bios_fabricante', 'Nome do fabricante da BIOS', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_cdrom_desc', 'Descri��o da unidade de CD-ROM', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_cpu_desc', 'Descri��o da CPU', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_cpu_fabricante', 'Fabricante da CPU', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_cpu_freq', 'Frequ�ncia da CPU', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_cpu_serial', 'N�mero de s�rie da CPU', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_dns_primario', 'IP do DNS prim�rio', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_dns_secundario', 'IP do DNS secund�rio', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_dominio_dns', 'Nome/IP do dom�nio DNS', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_dominio_windows', 'Nome/IP do dom�nio Windows', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_gateway', 'IP do gateway', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_ip', 'IP da esta��o', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_mascara', 'M�scara de Subrede', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_mem_ram_desc', 'Descri��o da mem�ria RAM', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_modem_desc', 'Descri��o do modem', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_mouse_desc', 'Descri��o do mouse', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_node_address', 'Endere�o MAC da esta��o', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_nomes_curtos_modulos', 'te_nomes_curtos_modulos', 'N');
INSERT INTO descricoes_colunas_computadores VALUES ('te_nome_computador', 'Nome do computador', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_nome_host', 'Nome do Host', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_origem_mac', 'te_origem_mac', 'N');
INSERT INTO descricoes_colunas_computadores VALUES ('te_placa_mae_desc', 'Descri��o da placa-m', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_placa_mae_fabricante', 'Fabricante da placa-m', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_placa_rede_desc', 'Descri��o da placa de rede', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_placa_som_desc', 'Descri��o da placa de som', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_placa_video_desc', 'Descri��o da placa de v�deo', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_placa_video_resolucao', 'Resolu��o da placa de v�deo', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_serv_dhcp', 'IP do servidor DHCP', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_teclado_desc', 'Descri��o do teclado', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_versao_cacic', 'Vers�o do Agente Principal do CACIC', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_versao_gercols', 'Vers�o do Gerente de Coletas do CACIC', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_wins_primario', 'IP do servidor WINS prim�rio', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_wins_secundario', 'IP do servidor WINS secund�rio', 'S');
INSERT INTO descricoes_colunas_computadores VALUES ('te_workgroup', 'Nome do grupo de trabalho', 'S');
UNLOCK TABLES;
/*!40000 ALTER TABLE `descricoes_colunas_computadores` ENABLE KEYS */;

--
-- Dumping data for table `grupo_usuarios`
--


/*!40000 ALTER TABLE `grupo_usuarios` DISABLE KEYS */;
LOCK TABLES `grupo_usuarios` WRITE;
INSERT INTO `grupo_usuarios` VALUES (1,'Comum','menu_com.txt','Usu�rio limitado, sem acesso a informa��es confidenciais como Softwares Inventariados e Op��es Administrativas como For�ar Coletas e Excluir Computador. Poder� alterar sua pr�pria senha.',0,''),(2,'Administra��o','menu_adm.txt','Acesso irrestrito.',1,''),(5,'Gest�o Central','menu_adm.txt','Acesso de leitura em todas as op��es.',2,''),(6,'Supervis�o','menu_sup.txt','Manuten��o de tabelas e acesso a todas as informa��es referentes � Localiza��o.',3,''),(7,'T�cnico','menu_tec.txt','Acesso t�cnico. Ser� permitido acessar configuracoes de rede e relat�rios de Patrim�nio e Hardware.',0,'');
UNLOCK TABLES;
/*!40000 ALTER TABLE `grupo_usuarios` ENABLE KEYS */;

--
-- Dumping data for table `patrimonio_config_interface`
--


/*!40000 ALTER TABLE `patrimonio_config_interface` DISABLE KEYS */;
	LOCK TABLES `patrimonio_config_interface` WRITE;
INSERT INTO `patrimonio_config_interface` VALUES (1,'etiqueta1','Etiqueta 1','Entidade','','Selecione a Entidade','Entidades','id_unid_organizacional_nivel1','N'),(2,'etiqueta1','Etiqueta 1','Entidade','','Selecione a Entidade','Entidades','id_unid_organizacional_nivel1','N'),(1,'etiqueta2','Etiqueta 2','org�o','','Selecione o org�o','org�os','id_unid_organizacional_nivel2','N'),(2,'etiqueta2','Etiqueta 2','org�o','','Selecione o org�o','org�os','id_unid_organizacional_nivel2','N'),(1,'etiqueta3','Etiqueta 3','Se��o','','Informe a Se��o onde est� instalado o equipamento.','Sess�es','te_localizacao_complementar','N'),(2,'etiqueta3','Etiqueta 3','Se��o','','Informe a Se��o onde est� instalado o equipamento','Sess�es','te_localizacao_complementar','N'),(1,'etiqueta4','Etiqueta 4','PIB da CPU','S','Informe o n�mero de PIB(tombamento) da CPU','','te_info_patrimonio1','S'),(2,'etiqueta4','Etiqueta 4','PIB da CPU','S','Informe o n�mero de PIB(tombamento) da CPU','','te_info_patrimonio1','S'),(1,'etiqueta5','Etiqueta 5','PIB do Monitor','S','Informe o n�mero de PIB(tombamento) do Monitor','','te_info_patrimonio2','S'),(2,'etiqueta5','Etiqueta 5','PIB do monitor','S','Informe o n�mero de PIB(tombamento) do monitor','','te_info_patrimonio2','S'),(1,'etiqueta6','Etiqueta 6','PIB da Impressora','S','Caso haja uma Impressora conectada informe n�mero de PIB(tombamento)','','te_info_patrimonio3','S'),(2,'etiqueta6','Etiqueta 6','PIB da impressora','S','Caso haja uma impressora conectada, informe o nr. de PIB(tombamento)','','te_info_patrimonio3','S'),(1,'etiqueta7','Etiqueta 7','Nr. S�rie CPU','S','Caso n�o disponha do nr. de PIB, informe o Nr. de S�rie da CPU','','te_info_patrimonio4','S'),(2,'etiqueta7','Etiqueta 7','Nr. s�rie CPU','S','Caso n�o disponha do nr. de PIB, informe o nr. de s�rie da CPU','','te_info_patrimonio4','S'),(1,'etiqueta8','Etiqueta 8','Nr. s�rie Monitor','S','Caso n�o disponha do nr. de PIB, informe o Nr. de S�rie do Monitor','','te_info_patrimonio5','S'),(2,'etiqueta8','Etiqueta 8','Nr. s�rie Monitor','S','Caso n�o disponha do nr. de PIB, informe o nr. de s�rie do Monitor','','te_info_patrimonio5','S'),(1,'etiqueta9','Etiqueta 9','Nr. S�rie Impres. (Opcional)','S','Caso haja uma impressora conectada ao micro e n�o disponha do nr. de PIB, informe seu nr. de s�rie','','te_info_patrimonio6','S'),(2,'etiqueta9','Etiqueta 9','Nr. s�rie Impres. (opcional)','S','Caso haja uma impressora conectada ao micro e n�o disponha do nr. de PIB, informe o nr. de s�rie','','te_info_patrimonio6','S');
UNLOCK TABLES;
/*!40000 ALTER TABLE `patrimonio_config_interface` ENABLE KEYS */;

--
-- Dumping data for table `perfis_aplicativos_monitorados`
--


/*!40000 ALTER TABLE `perfis_aplicativos_monitorados` DISABLE KEYS */;
LOCK TABLES `perfis_aplicativos_monitorados` WRITE;
INSERT INTO `perfis_aplicativos_monitorados` VALUES (8,'Windows 2000','0','','0','','0','','0','','1','HKEY_LOCAL_MACHINE\\SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\ProductId','2006-04-11 10:28:29','','','','','','',7,'','S','N',NULL),(16,'Windows 98 SE','0','','0','','0','','0','','1','HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\ProductId','2006-04-11 14:39:25','','','','','','',4,'','S','N',NULL),(20,'Windows XP','0','','0','','0','','0','','1','HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\ProductId','2006-04-11 10:29:29','','','','','','',8,'','S','N',NULL),(21,'Windows 95','0','','0','','0','','0','','1','HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\ProductId','2006-04-11 10:28:38','','','','','','',1,'','S','N',NULL),(22,'Windows 95 OSR2','0','','0','','0','','0','','1','HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\ProductId','2006-04-11 10:28:49','','','','','','',2,'','S','N',NULL),(23,'Windows NT','0','','0','','0','','0','','1','HKEY_LOCAL_MACHINE\\Software\\Microsoft\\Windows\\CurrentVersion\\ProductId','2006-04-11 10:29:18','','','','','','',6,'','S','N',NULL),(24,'Microsoft Office 2000','0','','0','','0','','0','','1','HKEY_LOCAL_MACHINE\\SOFTWARE\\Microsoft\\Office\\9.0\\Registration\\ProductID\\(Padr?o)','2006-04-11 10:28:15','','','','','','',0,'Suíte para escrit�rio com Editor de Textos, Planilha Eletr�nica, Banco de Dados, etc.','S','N',NULL),(50,'OpenOffice.org 1.1.3','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.1.3\\FriendlyAppName','0','OpenOffice.org1.1.3\\program\\soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.1.3\\FriendlyAppName','0','','2006-03-03 11:37:56','','','','','','',0,'','S','S',NULL),(51,'OpenOffice.org.br 1.1.3','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org.br 1.1.3\\FriendlyAppName','0','OpenOffice.org.br1.1.3\\program\\soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org.br 1.1.3\\FriendlyAppName','0','','2006-03-03 11:38:21','','','','','','',0,'','S','S',NULL),(52,'OpenOffice.org 1.1.0','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.1.0\\FriendlyAppName','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.1.0\\FriendlyAppName','0','','2006-03-03 11:37:25','','','','','','',0,'','S','S',NULL),(53,'OpenOffice.org 1.0.3','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.0.3\\FriendlyAppName','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.0.3\\FriendlyAppName','0','','2006-03-03 11:37:12','','','','','','',0,'','S','S',NULL),(54,'OpenOffice.org 1.1.1a','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.1.1a\\FriendlyAppName','0','soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org 1.1.1a\\FriendlyAppName','0','','2006-03-03 11:37:37','','','','','','',0,'','S','S',NULL),(67,'CACIC - Col_Anvi - Col. de Inf. de Anti-V�rus','0','','4','Cacic\\modulos\\col_anvi.exe','0','','4','Cacic\\modulos\\col_anvi.exe','0','','2006-01-19 19:34:20','','','','','','',0,'','N','S',NULL),(68,'CACIC - Col_Moni - Col. de Inf. de Sistemas Monitorados','0','','4','cacic\\modulos\\col_moni.exe','0','','4','cacic\\modulos\\col_moni.exe','0','','2006-01-19 19:34:12','','','','','','',0,'','N','S',NULL),(69,'CACIC - Col_Patr - Col. de Inf. de Patrim?nio e Loc. F?sica','0','','4','cacic\\modulos\\col_patr.exe','0','','4','cacic\\modulos\\col_patr.exe','0','','2006-01-19 19:35:03','','','','','','',0,'','N','S',NULL),(70,'CACIC - Col_Hard - Col. de Inf. de Hardware','0','','4','cacic\\modulos\\col_hard.exe','0','','4','cacic\\modulos\\col_hard.exe','0','','2006-01-19 19:34:38','','','','','','',0,'','N','S',NULL),(71,'CACIC - Col_Soft - Col. de Inf. de Softwares B?sicos','0','','4','cacic\\modulos\\col_soft.exe','0','','4','cacic\\modulos\\col_soft.exe','0','','2006-01-19 19:35:19','','','','','','',0,'','N','S',NULL),(72,'CACIC - Col_Undi - Col. de Inf. de Unidades de Disco','0','','4','cacic\\modulos\\col_undi.exe','0','','4','cacic\\modulos\\col_undi.exe','0','','2006-01-19 19:35:35','','','','','','',0,'','N','S',NULL),(73,'CACIC - Col_Comp - Col. de Inf. de Compartilhamentos','0','','4','cacic\\modulos\\col_comp.exe','0','','4','cacic\\modulos\\col_comp.exe','0','','2006-01-19 19:34:29','','','','','','',0,'','N','S',NULL),(74,'CACIC - Ini_Cols - Inicializador de Coletas','0','','4','cacic\\modulos\\ini_cols.exe','0','','4','cacic\\modulos\\ini_cols.exe','0','','2006-01-10 16:33:12','','','','','','',0,'','N','S',NULL),(75,'CACIC - Agente Principal','0','','4','Cacic\\cacic2.exe','0','','4','Cacic\\cacic2.exe','0','','2006-01-19 19:37:07','','','','','','',0,'','S','S',NULL),(76,'CACIC - Gerente de Coletas','0','','4','Cacic\\modulos\\ger_cols.exe','0','','4','Cacic\\modulos\\ger_cols.exe','0','','2006-01-19 19:37:46','','','','','','',0,'','S','S',NULL),(77,'OpenOffice.org 2.0','0','Arquivos de programas\\OpenOffice.org 2.0\\program\\soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org.br 2.0\\FriendlyAppName','0','Arquivos de programas\\OpenOffice.org 2.0\\program\\soffice.exe','2','HKEY_CLASSES_ROOT\\applications\\OpenOffice.org.br 2.0\\FriendlyAppName','0','','2006-03-03 11:38:11','','','','','','',0,'','S','S',NULL);
UNLOCK TABLES;
/*!40000 ALTER TABLE `perfis_aplicativos_monitorados` ENABLE KEYS */;

--
-- Dumping data for table `so`
--


/*!40000 ALTER TABLE `so` DISABLE KEYS */;
LOCK TABLES `so` WRITE;
INSERT INTO `so` VALUES (0,'S.O. Desconhecido','Desc.'),(1,'Windows 95','W95'),(2,'Windows 95 OSR2','W95OSR2'),(3,'Windows 98','W98'),(4,'Windows 98 SE','W98SE'),(5,'Windows ME','WME'),(6,'Windows NT','WNT'),(7,'Windows 2000','W2K'),(8,'Windows XP','WXP'),(9,'GNU/Linux','LNX'),(10,'FreeBSD','FBSD'),(11,'NetBSD','NBSD'),(12,'OpenBSD','OBSD'),(13,'Windows 2003','W2003');
UNLOCK TABLES;
/*!40000 ALTER TABLE `so` ENABLE KEYS */;

--
-- Dumping data for table `tipos_software`
--


/*!40000 ALTER TABLE `tipos_software` DISABLE KEYS */;
LOCK TABLES `tipos_software` WRITE;
INSERT INTO `tipos_software` VALUES (0,'Vers�o Trial'),(1,'Corre��o/Atualiza��o'),(2,'Sistema Interno'),(3,'Software Livre'),(4,'Software Licenciado'),(5,'Software Suspeito'),(6,'Software Descontinuado'),(7,'Jogos e Similares');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tipos_software` ENABLE KEYS */;

--
-- Dumping data for table `tipos_unidades_disco`
--


/*!40000 ALTER TABLE `tipos_unidades_disco` DISABLE KEYS */;
LOCK TABLES `tipos_unidades_disco` WRITE;
INSERT INTO `tipos_unidades_disco` VALUES ('1','Remov�vel'),('2','Disco R�gido'),('3','CD-ROM'),('4','Unid.Remota');
UNLOCK TABLES;
/*!40000 ALTER TABLE `tipos_unidades_disco` ENABLE KEYS */;
