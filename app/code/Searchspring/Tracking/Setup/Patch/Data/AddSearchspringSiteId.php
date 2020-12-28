<?php
declare(strict_types=1);

namespace Searchspring\Tracking\Setup\Patch\Data;

use Exception;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AddSearchspringSiteId
 *
 * @package Searchspring\Tracking\Setup\Patch\Data
 */
class AddSearchspringSiteId implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AddSearchspringSiteId constructor.
     *
     * @param Config $eavConfig
     * @param LoggerInterface $logger
     * @param EavSetupFactory $eavSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        Config $eavConfig,
        LoggerInterface $logger,
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->logger          = $logger;
        $this->eavConfig       = $eavConfig;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @return $this
     */
    public function apply(): self
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        try {
            $eavSetup->addAttribute(
                Product::ENTITY,
                'searchspring_site_id',
                [
                    'type'         => 'varchar',
                    'label'        => 'Searchspring Site ID',
                    'input'        => 'text',
                    'system'       => false,
                    'visible'      => true,
                    'required'     => false,
                    'user_defined' => true,
                    'position'     => 1,
                ]
            );
        } catch (Exception $e) {
            $this->logger->error($e);
        }
        return $this;
    }

    /**
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public static function getVersion(): string
    {
        return '1.0.0';
    }
}
