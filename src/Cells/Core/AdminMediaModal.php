<?php

namespace Btw\Core\Cells\Core;

use Btw\Core\Models\MediaModel;
use Btw\Core\Entities\Media;
use CodeIgniter\View\Cells\Cell;

class AdminMediaModal extends Cell
{
    protected string $view = 'admin_media_modal';
    protected $container;
    protected $identifier;
    protected $multiple = false;
    protected $accept_format = '';
    protected $value = [];
    protected $banner = false;
    public $media = []; // @todo Faille ? 
    public $target = 'addmedia'; // @todo Faille ? 


    public function mount($container, $identifier, $multiple, $accept_format, $value, $banner, $target = null)
    {
        if ($this->multiple == false) {
            if (isset($value[0])) {
                $identifier = (isValidUuid($value[0])) ? 'uuid' : 'id';
                if (!$media = model(MediaModel::class)->join('medias_langs', 'medias_langs.media_id = medias.id')->where('lang', service('language')->getLocale())->where($identifier, $value[0])->first()) {
                    $media = new Media;
                }
            } else {
                $media = new Media;
            }

            $this->media = $media;
        }
    }

    public function getContainerProperty(): string
    {
        return $this->container;
    }

    public function getIdentifierProperty(): string
    {
        return $this->identifier;
    }

    public function getMultipleProperty(): string
    {
        return $this->multiple;
    }

    public function getAcceptFormatProperty(): string
    {
        return $this->accept_format;
    }

    public function getValueFormatProperty(): array
    {
        return $this->value;
    }

    public function getMediaFormatProperty(): array
    {
        return $this->media;
    }

    public function getBannerProperty(): string
    {
        return $this->banner;
    }

    public function getTargetProperty(): string
    {
        return $this->target;
    }
}
