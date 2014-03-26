<?php

namespace Cacic\CommonBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 *
 * Repositório de métodos de consulta em DQL
 * @author lightbase
 *
 */
class SoftwareRepository extends EntityRepository
{
    public function paginar( \Knp\Component\Pager\Paginator $paginator, $page = 1 )
    {
        $_dql = "SELECT s, tipoSW.teDescricaoTipoSoftware AS tipoSoftware
				FROM CacicCommonBundle:Software s
				LEFT JOIN s.idTipoSoftware tipoSW
				ORDER BY s.nmSoftware ASC";

        return $paginator->paginate(
            $this->getEntityManager()->createQuery( $_dql ),
            $page,
            10
        );
    }
    /**
     *
     * Método de listagem dos Software cadastrados e respectivas informações
     */
    public function listar()
    {
        $_dql = "SELECT s, tipoSW.teDescricaoTipoSoftware AS tipoSoftware
				FROM CacicCommonBundle:Software s
				LEFT JOIN s.idTipoSoftware tipoSW
				ORDER BY s.nmSoftware ASC";

        return $this->getEntityManager()->createQuery( $_dql )->getArrayResult();
    }

    public function listarSoftware()
    {
        $qb = $this->createQueryBuilder('sw')
            ->select('sw.nmSoftware','class.idClassProperty')
            ->innerJoin('CacicCommonBundle:PropriedadeSoftware', 'prop', 'WITH', 'sw.idSoftware = prop.software')
            ->innerJoin('CacicCommonBundle:ClassProperty', 'class','WITH', 'prop.classProperty = class.idClassProperty')
            ->groupBy('sw.nmSoftware,class.idClassProperty, class.nmPropertyName')
            ->orderBy(' sw.nmSoftware');

        return $qb->getQuery()->execute();
    }

    /**
     *
     * Método de listagem dos Softwares cadastrados que não foram classificados (sem Tipo de Software)
     */
    public function listarNaoClassificados( \Knp\Component\Pager\Paginator $paginator, $page = 1)
    {
        $qb = $this->createQueryBuilder('sw')
            ->select('sw.nmSoftware','sw.idSoftware')
            ->innerJoin('CacicCommonBundle:PropriedadeSoftware', 'prop', 'WITH', 'sw.idSoftware = prop.software')
            ->innerJoin('CacicCommonBundle:ClassProperty', 'class','WITH', 'prop.classProperty = class.idClassProperty')
            ->where('sw.idTipoSoftware is null')
            ->groupBy('sw.nmSoftware,sw.idSoftware')
            ->orderBy('sw.nmSoftware');

        return $paginator->paginate(
            $qb->getQuery()->execute(),
            $page,
            10
        );

    }

    /**
     *
     * Método de listagem dos Softwares cadastrados que não estão associados a nenhuma máquina
     */
    public function listarNaoUsados()
    {
        $_dql = "SELECT s
				FROM CacicCommonBundle:Software s
				LEFT JOIN s.estacoes se
				WHERE se IS NULL
				ORDER BY s.nmSoftware ASC";

        return $this->getEntityManager()->createQuery( $_dql )->getArrayResult();
    }

    /**
     *
     * Método de consulta à base de dados de softwares inventariados
     * @param array $filtros
     */
    public function gerarRelatorioSoftwaresInventariados( $filtros )
    {
        // Monta a Consulta básica...
        $qb = $this->createQueryBuilder('sw')
            ->select('COALESCE(sw.nmSoftware, prop.displayName) as nmSoftware', 'l.nmLocal','COUNT(DISTINCT col.computador) AS numComp')
            ->innerJoin('CacicCommonBundle:PropriedadeSoftware', 'prop', 'WITH', 'sw.idSoftware = prop.software')
            ->innerJoin('CacicCommonBundle:ClassProperty', 'class','WITH', 'prop.classProperty = class.idClassProperty')
            ->innerJoin('CacicCommonBundle:ComputadorColeta', 'col', 'WITH', 'col.computador = prop.computador')
            ->innerJoin('CacicCommonBundle:Computador', 'comp', 'WITH', 'col.computador = comp.idComputador')
            ->innerJoin('comp.idRede','r')
            ->leftJoin('r.idLocal', 'l')
            ->groupBy('sw.nmSoftware, prop.displayName, l.nmLocal')
            ->orderBy('sw.nmSoftware, l.nmLocal');

        /**
         * Verifica os filtros que foram parametrizados
         */
        if ( array_key_exists('softwares', $filtros) && !empty($filtros['softwares']) )
            $qb->andWhere('class.idClassProperty IN (:softwares)')->setParameter('softwares', explode( ',', $filtros['softwares'] ));

        if ( array_key_exists('locais', $filtros) && !empty($filtros['locais']) )
            $qb->andWhere('l.idLocal IN (:locais)')->setParameter('locais', explode( ',', $filtros['locais'] ));

        if ( array_key_exists('redes', $filtros) && !empty($filtros['redes']) )
            $qb->andWhere('r.idRede IN (:redes)')->setParameter('redes', explode( ',', $filtros['redes'] ));

        if ( array_key_exists('so', $filtros) && !empty($filtros['so']) )
            $qb->andWhere('comp.idSo IN (:so)')->setParameter('so', explode( ',', $filtros['so'] ));

        return $qb->getQuery()->execute();
    }

    /**
     *
     * Método de consulta à base de dados de softwares licenciados
     * @param array $filtros
     */
    public function gerarRelatorioSoftwaresLicenciados( $filtros )
    {
        // Monta a Consulta básica...
        $qb = $this->createQueryBuilder('sw')
            ->select('sw.nmSoftware', 'aqit.qtLicenca', 'aqit.dtVencimentoLicenca', 'aq.nrProcesso', 'tpl.teTipoLicenca')
            ->innerJoin('CacicCommonBundle:AquisicaoItem','aqit','WITH','sw.idSoftware = aqit.idSoftware')
            ->innerJoin('CacicCommonBundle:Aquisicao','aq','WITH','aq.idAquisicao = aqit.idAquisicao')
            ->innerJoin('CacicCommonBundle:TipoLicenca','tpl','WITH','tpl.idTipoLicenca = aqit.idTipoLicenca')
            ->orderBy('sw.nmSoftware');
    
        /**
         * Verifica os filtros que foram parametrizados
         */
        if ( array_key_exists('softwares', $filtros) && !empty($filtros['softwares']) )
            $qb->andWhere('sw.idSoftware IN (:softwares)')->setParameter('softwares', explode( ',', $filtros['softwares'] ));

        return $qb->getQuery()->execute();
    }

    /**
     *
     * Método de consulta à base de dados de softwares por órgão
     * @param array $filtros
     */
    public function gerarRelatorioSoftwaresPorOrgao( $filtros )
    {
        // Monta a Consulta básica...
        $qb = $this->createQueryBuilder('sw')
            ->select('sw', 'se', 'comp')
            ->innerJoin('sw.estacoes', 'se')
            ->innerJoin('se.idComputador', 'comp')
            ->orderBy('sw.nmSoftware')->addOrderBy('comp.nmComputador')->addOrderBy('comp.teIpComputador');

        /**
         * Verifica os filtros que foram parametrizados
         */
        if ( array_key_exists('TipoSoftware', $filtros) && !empty($filtros['TipoSoftware']) )
            $qb->innerJoin('sw.idTipoSoftware', 'tpsw')->andWhere('tpsw.idTipoSoftware IN (:tpsw)')->setParameter('tpsw', explode( ',', $filtros['TipoSoftware'] ));

        if ( array_key_exists('nmComputador', $filtros) && !empty($filtros['nmComputador']) )
            $qb->andWhere('comp.nmComputador LIKE :nmComputador')->setParameter('nmComputador', "%{$filtros['nmComputador']}%" );

        return $qb->getQuery()->execute();
    }

    /**
     *
     * Método de consulta à base de dados de softwares por tipo
     * @param array $filtros
     */
    public function gerarRelatorioSoftwaresPorTipo( $filtros )
    {
        // Monta a Consulta básica...
        $qb = $this->createQueryBuilder('sw')
            ->select('COALESCE( sw.nmSoftware) as nmSoftware', 'tipo.teDescricaoTipoSoftware', 'COUNT(DISTINCT col.computador) AS numComp')
            ->innerJoin('CacicCommonBundle:PropriedadeSoftware', 'prop', 'WITH', 'sw.idSoftware = prop.software')
            ->innerJoin('CacicCommonBundle:ComputadorColeta', 'col', 'WITH', 'col.computador = prop.computador')
            ->innerJoin('CacicCommonBundle:Computador', 'comp', 'WITH', 'col.computador = comp.idComputador')
            ->innerJoin('CacicCommonBundle:TipoSoftware', 'tipo', 'WITH', 'sw.idTipoSoftware = tipo.idTipoSoftware')
            ->groupBy('tipo.teDescricaoTipoSoftware, sw.nmSoftware, tipo.idTipoSoftware');

        /**
         * Verifica os filtros que foram parametrizados
         */
        if ( array_key_exists('TipoSoftware', $filtros) && !empty($filtros['TipoSoftware']) )
            $qb->andWhere('tipo.idTipoSoftware IN (:tpsw)')->setParameter('tpsw', explode( ',', $filtros['TipoSoftware'] ));

        return $qb->getQuery()->execute();
    }

    /**
     *
     * Método de consulta à base de dados de softwares não vinculados a nenhuma estação
     * @param array $filtros
     */
    public function gerarRelatorioSoftwaresNaoVinculados()
    {
        // Monta a Consulta básica...
        $qb = $this->createQueryBuilder('sw');
        $qb->select('sw', 'tpsw', 'se')
            ->leftJoin('sw.idTipoSoftware', 'tpsw')
            ->leftJoin('sw.estacoes', 'se')
            ->groupBy('sw', 'tpsw.idTipoSoftware', 'tpsw.teDescricaoTipoSoftware', 'se')
            ->having($qb->expr()->eq($qb->expr()->count('se'), 0))
            ->orderBy('sw.nmSoftware');

        return $qb->getQuery()->execute();
    }
    public function gerarRelatorioPatrimonio( $filtros )
    {
        // Monta a Consulta básica...
        $qb = $this->createQueryBuilder('sw')
            ->select( 'comp.nmComputador', 'sw.nmSoftware', 'so.sgSo', 'r.teIpRede', 'l.nmLocal', 'pci.teEtiqueta', 'pci.idEtiqueta','comp.idComputador','so.inMswindows')
            ->innerJoin('CacicCommonBundle:SoftwareEstacao', 'se','WITH','sw.idSoftware = se.idSoftware')
            ->innerJoin('CacicCommonBundle:Computador', 'comp','WITH','se.idComputador = comp.idComputador')
            ->leftJoin('CacicCommonBundle:So', 'so','WITH','comp.idSo = so.idSo')
            ->leftJoin('CacicCommonBundle:Rede', 'r','WITH', 'comp.idRede = r.idRede')
            ->innerJoin('CacicCommonBundle:Local','l','WITH', 'r.idLocal = l.idLocal')
            ->innerJoin('CacicCommonBundle:PatrimonioConfigInterface','pci','WITH','l.idLocal = pci.local')
            ->groupBy('comp.nmComputador, sw.nmSoftware, so.sgSo, r.teIpRede,  l.nmLocal, pci.teEtiqueta, pci.idEtiqueta,comp.idComputador,so.inMswindows')
            ->orderBy('sw.nmSoftware, l.nmLocal, pci.idEtiqueta');

        /*
         * Verifica os filtros que foram parametrizados
         */

        if ( array_key_exists('softwares', $filtros) && !empty($filtros['softwares']) )
            $qb->andWhere('sw.idSoftware IN (:softwares)')->setParameter('softwares', explode( ',', $filtros['softwares'] ));

        if ( array_key_exists('locais', $filtros) && !empty($filtros['locais']) )
            $qb->andWhere('l.idLocal IN (:locais)')->setParameter('locais', explode( ',', $filtros['locais'] ));

        if ( array_key_exists('so', $filtros) && !empty($filtros['so']) )
            $qb->andWhere('comp.idSo IN (:so)')->setParameter('so', explode( ',', $filtros['so'] ));

        if ( array_key_exists('pci', $filtros) && !empty($filtros['pci']) )
            $qb->andWhere('pci.idEtiqueta IN (:pci)')->setParameter('pci', explode( ',', $filtros['pci'] ));

        return $qb->getQuery()->execute();
    }

}