<?php

namespace App\Processors\Web;

use App\Model\GalleryItem;
use Illuminate\Database\Eloquent\Builder;

class Gallery extends \App\GetProcessor
{

    protected $class = '\App\Model\GalleryItem';


    protected function beforeGet($c)
    {
        return $this->beforeCount($c);
    }


    /**
     * @param Builder $c
     *
     * @return Builder
     */
    protected function beforeCount($c)
    {
        $c->where([
            'object_id' => (int)$this->getProperty('object_id'),
            'object_name' => $this->getProperty('object_name'),
            'active' => true,
        ]);
        $c->orderBy('rank', 'asc');

        return parent::beforeCount($c);
    }


    /**
     * @param GalleryItem $object
     *
     * @return array
     */
    public function prepareRow($object)
    {
        $file = $object->file;
        $array = [
            'id' => $object->file_id,
            'file' => $file->getUrl(),
            'rank' => $object->rank,
            //'title' => $file->title,
            //'description' => $file->description,
        ];

        return $array;
    }
}