<?php

declare(strict_types=1);

namespace Domain\Pagination;

class Pagination
{
    private array $entities;

    private PageInfo $pageInfo;

    public function __construct(
        array $entities,
        int $pageNumber,
        int $lastPage
    ) {
        $this->entities = $entities;
        $this->pageInfo = new PageInfo(
            $pageNumber,
            $lastPage
        );
    }

    /**
     * @return object[]
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    public function getPageInfo(): PageInfo
    {
        return $this->pageInfo;
    }
}
