<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Component\DataSource\Field;

/**
 * {@inheritdoc}
 */
class FieldAbstractExtension implements FieldExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedFieldTypes()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function initOptions(FieldTypeInterface $field)
    {
    }
}
