<?php

namespace App\Service;

class LinkService
{
    public function getObjectLinks(string $model = '', $object, array $flags = [])
    {
        $data = [
            $model => $object
        ];

        foreach ($flags as $flag) {
            $data['_links'][$flag] = $this->getLink($model, $flag, $object);
        }

        return $data;
    }

    public function getObjectsLinks(string $model = '', array $objects, array $flags = [])
    {
        $data = [];
        foreach ($objects as $object) {
            
            $link = [];

            foreach ($flags as $flag) {
                $link[] = $this->getLink($model, $flag, $object);
            }
            
            $data[] = [
                $model => $object,
                '_links' => $link
            ];
        }

        return $data;
    }

    public function getLink(string $model, string $flag, $object)
    {
        if ($flag === 'all') {
            return "/api/$model";
        }

        return "/api/$model/{$object->getId()}";
    }
}
