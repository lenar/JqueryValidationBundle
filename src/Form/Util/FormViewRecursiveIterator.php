<?php
namespace Boekkooi\Bundle\JqueryValidationBundle\Form\Util;

use RecursiveIterator;

class FormViewRecursiveIterator extends \IteratorIterator implements \RecursiveIterator
{
    /**
     * {@inheritdoc}
     */
    public function getChildren(): ?RecursiveIterator
    {
        return new static($this->current());
    }

    /**
     *{@inheritdoc}
     */
    public function hasChildren()
    {
        return $this->current()->count() > 0;
    }
}
