<?php
/**
 * NativeMind Marketplace Admin Seller Grid Rating Renderer
 *
 * @category    NativeMind
 * @package     NativeMind_Marketplace
 * @author      NativeMind <contact@nativemind.net>
 * @copyright   Copyright (c) 2024 NativeMind (https://nativemind.net)
 * @license     https://opensource.org/licenses/MIT
 */

namespace NativeMind\Marketplace\Block\Adminhtml\Seller\Grid\Renderer;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Framework\DataObject;

/**
 * Class Rating
 * @package NativeMind\Marketplace\Block\Adminhtml\Seller\Grid\Renderer
 */
class Rating extends AbstractRenderer
{
    /**
     * {@inheritdoc}
     */
    public function render(DataObject $row)
    {
        $rating = $row->getData($this->getColumn()->getIndex());
        
        if (!$rating || $rating == 0) {
            return __('No Rating');
        }

        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<span style="color: #ffc107;">★</span>';
            } else {
                $stars .= '<span style="color: #ddd;">☆</span>';
            }
        }

        return $stars . ' (' . number_format($rating, 1) . ')';
    }
}
