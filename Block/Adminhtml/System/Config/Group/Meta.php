<?php
declare(strict_types=1);

namespace Takyon\Core\Block\Adminhtml\System\Config\Group;

use Magento\Backend\Block\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Config\Block\System\Config\Form\Fieldset;
use Magento\Framework\Phrase;
use Magento\Framework\View\Helper\Js;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

class Meta extends Fieldset
{
    public function __construct(
        Context $context,
        Session $authSession,
        Js $jsHelper,
        private string $version,
        private string $documentationUrl,
        private ?string $moduleCode = null,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        parent::__construct($context, $authSession, $jsHelper, $data, $secureRenderer);
    }

    protected function _getHeaderTitleHtml($element): string
    {
        return '<a id="' . $element->getHtmlId() . '-head">' . $element->getLegend() . '</a>';
    }

    protected function _getExtraJs($element): string
    {
        return '';
    }

    protected function _getFooterHtml($element): string
    {
        $html = sprintf(
            '%s: %s<br />%s%s',
            __('Version'),
            $this->version,
            $this->getLinkHtml(__('Documentation'), $this->documentationUrl),
            $this->getLinkHtml(__('Contact Support'), 'https://takyoncommerce.com/support')
        );

        return $html . parent::_getFooterHtml($element);
    }

    private function getLinkHtml(Phrase $label, string $url): string
    {
        $params = [
            'utm_source' => 'magento_module',
            'utm_medium' => 'store_configuration_meta'
        ];

        if ($this->moduleCode) {
            $params['utm_campaign'] = $this->moduleCode;
        }

        return sprintf(
            '<a href="%s" class="takyon-meta-fieldset__link">%s</a>',
            $url . '?' . http_build_query($params),
            $label
        );
    }
}
