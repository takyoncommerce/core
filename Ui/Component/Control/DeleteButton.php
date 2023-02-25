<?php
declare(strict_types=1);

namespace Takyon\Core\Ui\Component\Control;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton implements ButtonProviderInterface
{
    public function __construct(
        private RequestInterface $request,
        private UrlInterface $urlBuilder,
        private string $requestFieldName,
        private string $confirmationMessage,
        private string $deleteRoutePath = '*/*/delete',
        private ?string $label = null
    ) {}

    public function getButtonData(): array
    {
        $entityId = (int) $this->request->getParam($this->requestFieldName);
        if (!$entityId) {
            return [];
        }

        return [
            'label' => $this->label ?? __('Delete'),
            'class' => 'delete',
            'on_click' => sprintf(
                "deleteConfirm('%s', '%s', {data:{%s: %s}})",
                $this->confirmationMessage,
                $this->urlBuilder->getUrl($this->deleteRoutePath),
                $this->requestFieldName,
                $entityId
            )
        ];
    }
}
