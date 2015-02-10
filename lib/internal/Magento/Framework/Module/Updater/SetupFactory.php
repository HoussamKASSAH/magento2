<?php
/**
 * Module setup factory. Creates setups used during application install/upgrade.
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Module\Updater;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Setup\ModuleDataResourceInterface;

class SetupFactory
{
    const INSTANCE_TYPE = 'Magento\Framework\Setup\ModuleDataResourceInterface';

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var array
     */
    protected $_resourceTypes;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param array $resourceTypes
     */
    public function __construct(ObjectManagerInterface $objectManager, array $resourceTypes)
    {
        $this->_objectManager = $objectManager;
        $this->_resourceTypes = $resourceTypes;
    }

    /**
     * @param string $resourceName
     * @param string $moduleName
     * @return ModuleDataResourceInterface
     * @throws \LogicException
     */
    public function create($resourceName, $moduleName)
    {
        $className = isset(
            $this->_resourceTypes[$resourceName]
        ) ? $this->_resourceTypes[$resourceName] : self::INSTANCE_TYPE;

        if (false == is_subclass_of($className, self::INSTANCE_TYPE) && $className !== self::INSTANCE_TYPE) {
            throw new \LogicException($className . ' must implement \\' . self::INSTANCE_TYPE);
        }

        return $this->_objectManager->create(
            $className,
            ['resourceName' => $resourceName, 'moduleName' => $moduleName]
        );
    }
}
