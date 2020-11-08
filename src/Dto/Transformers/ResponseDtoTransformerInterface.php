<?php


namespace App\Dto\Transformers;


interface ResponseDtoTransformerInterface
{

    public function transformFromObject($object);

    public function transformFromObjects(iterable $objects): iterable;
}