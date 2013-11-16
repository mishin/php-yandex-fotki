<?php
namespace Yandex\Fotki\Api;

/**
 * Class AlbumsCollection
 * @package Yandex\Fotki\Api
 * @author Dmitry Kuznetsov <kuznetsov2d@gmail.com>
 * @license The MIT License (MIT)
 * @see http://api.yandex.ru/fotki/doc/operations-ref/albums-collection-get.xml
 * @method \Yandex\Fotki\Api\AlbumsCollection setOrder(\string $order)
 * @method \Yandex\Fotki\Api\AlbumsCollection setLimit(\int $limit)
 * @method \Yandex\Fotki\Api\Album[] getList()
 */
class AlbumsCollection extends \Yandex\Fotki\Api\CollectionAbstract
{
    /**
     * @return self
     * @throws \Yandex\Fotki\Exception\Api\AlbumsCollection
     */
    public function load()
    {
        try {
            $data = $this->_getData($this->_transport, $this->_getApiUrlWithParams($this->_apiUrl));
        } catch (\Yandex\Fotki\Exception\Api $ex) {
            throw new \Yandex\Fotki\Exception\Api\AlbumsCollection($ex->getMessage(), $ex->getCode(), $ex);
        }
        $this->_apiUrlNextPage = null;
        if (isset($data['links']['next'])) {
            $this->_apiUrlNextPage = (string)$data['links']['next'];
        }
        if (isset($data['updated'])) {
            $this->_dateUpdated = (string)$data['updated'];
        }
        foreach ($data['entries'] as $entry) {
            $album = new \Yandex\Fotki\Api\Album($this->_transport, $entry['links']['self']);
            $album->initWithData($entry);
            $this->_data[$album->getId()] = $album;
        }
        return $this;
    }
}