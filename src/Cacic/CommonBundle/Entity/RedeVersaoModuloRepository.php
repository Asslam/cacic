<?php

namespace Cacic\CommonBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 *
 * Repositório de métodos de consulta em DQL
 * @author lightbase
 *
 */
class RedeVersaoModuloRepository extends EntityRepository
{

    /**
     *
     * Método de listagem dos Modulos cadastrados e respectivas informações
     */
    public function listarWindows()
    {
        $_dql = "SELECT r
				FROM CacicCommonBundle:RedeVersaoModulo r
				where r.csTipoSo = 'MS-Windows'
				ORDER BY r.nmModulo ASC";

        return $this->getEntityManager()->createQuery( $_dql )->getArrayResult();
    }
    public function listarLinux()
    {
        $_dql = "SELECT r
				FROM CacicCommonBundle:RedeVersaoModulo r
				where r.csTipoSo = 'GNU/LINUX'
				ORDER BY r.nmModulo ASC";

        return $this->getEntityManager()->createQuery( $_dql )->getArrayResult();
    }
    /*
     * Traz a lista de módulos para a subrede fornecida
     */
    public function subrede($id = null, $modulo = null)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('red.idRede',
                'r.nmModulo',
                'r.teVersaoModulo',
                'r.teHash',
                'red.teIpRede',
                'red.nmRede',
                'red.teServUpdates',
                'red.tePathServUpdates',
                'l.nmLocal')
            ->innerJoin('CacicCommonBundle:Rede', 'red', 'WITH', 'red.idRede = r.idRede')
            ->innerJoin('CacicCommonBundle:Local', 'l', 'WITH', 'red.idLocal = l.idLocal')
            ->groupBy('r', 'l', 'red')
            ->orderBy('red.nmRede');

        // Adiciona filtro por módulo se fornecido
        if ($modulo != null) {
            // Aqui trago somente a lista de todos os módulos naquela subrede
            $qb->andWhere('r.nmModulo = :modulo')->setParameter('modulo', $modulo);
        }

        // Adiciona filtro por subrede se fornecido
        if ($id != null) {
            // Somente os módulos desa subrede
            $qb->andWhere('r.idRede = :id')->setParameter('id', $id);
        }

        return $qb->getQuery()->getArrayResult();
    }

    /*
     * Traz a lista de módulos para a subrede fornecida
     */
    public function subredeFilePath($id = null, $modulo = null)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('red.idRede',
                'r.nmModulo',
                'r.teVersaoModulo',
                'r.teHash',
                'red.teIpRede',
                'red.nmRede',
                'red.teServUpdates',
                'red.tePathServUpdates',
                'l.nmLocal')
            ->innerJoin('CacicCommonBundle:Rede', 'red', 'WITH', 'red.idRede = r.idRede')
            ->innerJoin('CacicCommonBundle:Local', 'l', 'WITH', 'red.idLocal = l.idLocal')
            ->groupBy('r', 'l', 'red')
            ->orderBy('red.nmRede');

        // Adiciona filtro por módulo se fornecido
        if ($modulo != null) {
            // Aqui trago somente a lista de todos os módulos naquela subrede
            $qb->andWhere('r.filepath = :modulo')->setParameter('modulo', $modulo);
        }

        // Adiciona filtro por subrede se fornecido
        if ($id != null) {
            // Somente os módulos dessa subrede
            $qb->andWhere('r.idRede = :id')->setParameter('id', $id);
        }

        return $qb->getQuery()->getArrayResult();
    }

    public function getUpdate($idRede, $te_versao_cacic) {
        # 1 - Verifica se a versão é 2.8 e diferente da versão 2.8.1.23
        preg_match("/^2.(.*)/", $te_versao_cacic, $arrResult);
        preg_match("/^0.(.*)/", $te_versao_cacic, $arrResult2);
        if (!empty($arrResult) || !empty($arrResult2)) {
            # 1.1 - Se for qualquer versão 2.8, manda a versão 2.8.1.23 como padrão
            $saida = array();
            $cacic280 = new RedeVersaoModulo('cacic280.exe', '2.8.1.23', null, 'windows', null, $idRede);
            $cacic280->setTeHash('6bec84cb246c49e596256d4833e6b301');
            array_push($saida, $cacic280);

            $cacicserv = new RedeVersaoModulo('cacicservice.exe', '2.8.1.23', null, 'windows', null, $idRede);
            $cacicserv->setTeHash('3119b4e67d71fcec2700770632974a31');
            array_push($saida, $cacicserv);

            $chksis = new RedeVersaoModulo('chksis.exe', '2.8.1.23', null, 'windows', null, $idRede);
            $chksis->setTeHash('748b8265eb0cd80e1854a90fe34df671');
            array_push($saida, $chksis);

            $gercols = new RedeVersaoModulo('gercols.exe', '2.8.1.23', null, 'windows', null, $idRede);
            $gercols->setTeHash('6e358a7302e8c9b3d0c09fbd9c7a7000');
            array_push($saida, $gercols);

            $installcacic = new RedeVersaoModulo('installcacic.exe', '2.8.1.23', null, 'windows', null, $idRede);
            $installcacic->setTeHash('388c9d020e72f5b62696824cc69077ea');
            array_push($saida, $installcacic);

            $mapacacic = new RedeVersaoModulo('mapacacic.exe', '2.8.1.23', null, 'windows', null, $idRede);
            $mapacacic->setTeHash('3f8a6191fbad092eeb202617288559e9');
            array_push($saida, $mapacacic);

            return $saida;
        }

        # 1.2 - Se não for, traz a versão normal para a rede
        return $this->findBy(array('idRede' => $idRede ));

    }

    public function getModulo($rede, $modulo, $tipo_so) {
        $em = $this->getEntityManager();

        $qb = $this->createQueryBuilder('m')
            ->select('m.nmModulo',
                'm.teHash')
            ->innerJoin('CacicCommonBundle:TipoSo', 't', 'WITH', 'm.tipoSo = t.idTipoSo')
            ->andWhere('m.nmModulo = :modulo')
            ->andWhere('t.tipo = :tipo_so')
            ->andWhere('m.idRede = :rede')
            ->andWhere("m.tipo = 'cacic'")
            ->setMaxResults(1)
            ->setParameter('modulo', $modulo)
            ->setParameter('tipo_so', $tipo_so)
            ->setParameter('rede', $rede)
            ->orderBy('m.dtAtualizacao', 'DESC');

        return $qb->getQuery()->getArrayResult();
    }

}
