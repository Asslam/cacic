<?php

namespace Cacic\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *
 * Formulário de PESQUISA por Classe WMI
 * @author Bruno Noronha
 *
 */
class ClassePesquisaType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options )
    {

        $builder->add(
            'nmClassName',
            'entity',
            array(
                'class' => 'CacicCommonBundle:Classe',
                'property' => 'nmClassName',
                'multiple' => true,
                'required'  => true,
                'expanded'  => true,
                'label'=> 'Selecione a Classe:'
            )
        );

        $builder->add(
            'usuario',
            null,
            array( 'label'=>'', 'max_length'=>30, 'required'  => true)
        );
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'classe_pesquisa';
    }

}