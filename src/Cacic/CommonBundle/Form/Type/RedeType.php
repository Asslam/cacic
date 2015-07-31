<?php

namespace Cacic\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Cacic\CommonBundle\Form\DataTransformer\cxTelefoneTransformer;

/**
 *
 *
 * @author lightbase
 *
 */
class RedeType extends AbstractType
{

	public function buildForm( FormBuilderInterface $builder, array $options )
	{
		$builder->add( 'idLocal', null,
			array(
				'empty_value' => 'Selecione o Local',
				'class' => 'CacicCommonBundle:Local',
				'property' => 'nmLocal',
                'required' =>true,
				'label' => 'Local'
			)
		);

		$builder->add('idServidorAutenticacao', 'entity',
			array(
				'empty_value' => 'Selecione o Servidor',
                'required'  => false,
				'class' => 'CacicCommonBundle:ServidorAutenticacao',
				'property' => 'nmServidorAutenticacao',
				'label'=>'Servidor para Autenticação:'
            )
		);

		$builder->add('teIpRede',  null,
			array(
				 'label'=> 'Subrede'
			)
		);
		$builder->add('nmRede',  null,
			array(
				'label'=> 'Descrição',
			)
		);
		$builder->add('teMascaraRede', null,
			array(
				'label'=>'Máscara',
				'data'=>'255.255.255.0'
			)
		);
		$builder->add('teServCacic', null,
			 array(
				 'label'=>'Servidor de Aplicação'
			 )
		);
        /*
        $builder->add('selTeServCacic', 'entity',
             array(
                 'empty_value' => '==> Selecione <==',
                 'label'=>' ',
                 'required'  => false,
                 'mapped'=>false,
                 'class' => 'CacicCommonBundle:Rede',
                 'property' => 'teServCacic'
             )
        );
        */
        $builder->add('teServUpdates', null,
            array(
                'label'=>'Servidor para download dos Agentes'
            )
        );
        $builder->add('downloadMethod', 'choice',
            array(
                'label'=>'Método de download',
                'choices'   => array(
                    'ftp' => 'FTP', 
                    'http' => 'HTTP'
                ),
                'required'  => true,
                //'data' => 'ftp',
                //'expanded'  => true,
            )
        );
        /*
        $builder->add('selTeServUpdates', 'entity',
            array(
                'empty_value' => '==> Selecione <==',
                'label'=>' ',
                'required'  => false,
                'mapped'=>false,
                'class' => 'CacicCommonBundle:Rede',
                'property' => 'teServUpdates'
            )
        );
        */
        $builder->add('nuPortaServUpdates', null,
             array(
                 'label' => 'Porta',
                 'data'=>'21',
                 'required' => false
             )
        );
        /*
        $builder->add('nuLimiteFtp', null,
            array(
                'label' => 'Limite FTP',
                'data'=>'100',
                'required' => false
            )
        );
        */
        $builder->add('nmUsuarioLoginServUpdates', null,
            array(
                'label' => 'Usuário do Servidor de Updates (para AGENTE)'
            )
        );
        $builder->add('teSenhaLoginServUpdates', 'password',
            array(
                'label' => 'Senha para Login',
                'required'  => false
            )
        );
        /*
        $builder->add('nmUsuarioLoginServUpdatesGerente', null,
            array(
                'label' => 'Usuário do Servidor de Updates (para GERENTE)',
                'required' => false
            )
        );

        $builder->add('teSenhaLoginServUpdatesGerente', 'password',
            array(
                'label' => 'Senha para Login',
                'required'  => false
            )
        );
        */
        $builder->add('tePathServUpdates', null,
             array(
                 'label' => 'Path no Servidor de Updates',
                 'required' => false
             )
         );
        $builder->add('teObservacao', 'textarea',
            array(
                'label' => 'Observações',
                'required'  => false
            )
        );
        $builder->add('nmPessoaContato1', null,
            array(
                'label' => 'Contato 1',
                'required'  => false
            )
        );
        $builder->add(
        		$builder->create(
        				'nuTelefone1',
        				null,
        				array( 'label'=>'Telefone' )
        		)
        		->addModelTransformer( new CxTelefoneTransformer() )
        );
        $builder->add('teEmailContato1', 'email',
            array(
                'label' => 'E-mail',
                'required'  => false
            )
        );
        $builder->add('nmPessoaContato2', null,
            array(
                'label' => 'Contato 2',
                'required'  => false
            )
        );
        $builder->add(
        		$builder->create(
        				'nuTelefone2',
        				null,
        				array( 'label'=>'Telefone' )
        		)
        		->addModelTransformer( new CxTelefoneTransformer() )
        );
        $builder->add('teEmailContato2', 'email',
            array(
                'label' => 'E-mail',
                'required'  => false
            )
        );
        $builder->add('habilitar', 'choice',
            array(
                'label' => 'Marcar todas as ações',
                'choices'   => array(true => 'Sim', false => 'Não'),
                'required'  => true,
                //'expanded'  => true,
                'mapped'=>false,
            )
        );
        /*$builder->add('csPermitirDesativarSrcacic', 'choice',
            array(
                'choices'   => array(true => 'Sim', false => 'Não'),
                'required'  => true,
                'data' => 'N',
                //'expanded'  => true,
                'label' => ' '

            )
        );
        $builder->add('idAplicativo', 'entity',
             array(
                 'class' => 'CacicCommonBundle:Aplicativo',
                 'property' => 'nmAplicativo',
                 'required'  => false,
                 'expanded'  => true,
                 'multiple'  => true,
                 'label' => ' '
             )
        );*/
	}

	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Form.FormTypeInterface::getName()
	 */
	public function getName()
	{
		return 'rede';
	}


}
