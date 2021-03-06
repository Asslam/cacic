<?php

namespace Cacic\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

/**
 *
 *
 * @author lightbase
 *
 */
class GrupoUsuarioType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options )
    {

        $builder->add( 'teGrupoUsuarios', 'text',
            array(
                'max_length' => 50,
                'label' => 'Nome do Grupo de Usuário:'
            )
        );

        $builder->add( 'nmGrupoUsuarios', 'choice',
            array(
                'label' => 'Permissão:',
                'choices' => array(
                    '' => '==> Selecione <==',
                    'devel' => 'Desenvolvedores',
                    'Admin' => 'Administradores',
                    'gestao' => 'Gestão Central',
                    'comum' => 'Comum'
                ),
                'expanded' => false,
                'multiple' => false
            )
        );


        $builder->add( 'teDescricaoGrupo', 'textarea',
            array(
                'max_length' => 100,
                'required'=>false,
                'label' => 'Descrição do grupo',
            )
        );
    }
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'grupoUsuario';
    }


}