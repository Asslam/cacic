<?php

namespace Cacic\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Created by PhpStorm.
 * User: Bruno Noronha
 * Date: 17/03/15
 * Time: 14:42
 */
class TeSoType extends AbstractType
{

    public function buildForm( FormBuilderInterface $builder, array $options )
    {
        $builder->add(
            'idSo',
            null,
            array( 'label'=>'Id Externa' )
        );
        $builder->add(
            'teSo28',
            null,
            array( 'label'=>'SO 2.8' )
        );
        $builder->add(
            'teSo31',
            null,
            array( 'label'=>'SO 31' )
        );
        $builder->add(
            'id',
            null,
            array( 'label'=>'ID',
                'read_only' =>true
            )
        );
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'TeSo';
    }

}