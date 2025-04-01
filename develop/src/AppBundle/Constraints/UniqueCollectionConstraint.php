<?php

namespace AppBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @Annotation
 */
class UniqueCollectionConstraint extends Constraint
{
    public $message = 'Коллекция "%s" должна содержать уникальные элементы';
    public $collectionName = '';
    public $field = '';

    /**
     * UniqueCollectionConstraint constructor.
     * @param null $options
     */
    public function __construct($options = null)
    {
        parent::__construct($options);

        if (empty($this->field)) {
            throw new MissingOptionsException('Необходимо передать опцию field', $options);
        }
    }
} 