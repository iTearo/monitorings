<?php

declare(strict_types=1);

namespace Monitorings\Pagination;

class PageInfo
{
    private int $currentPage;

    private int $lastPage;

    public function __construct(
        int $pageNumber,
        int $lastPage
    ) {
        $this->currentPage = $pageNumber;
        $this->lastPage = $lastPage;
    }

    public function toArray(): array
    {
        $data = [
            'startPage' => max(1,  $this->currentPage - 2),

            'current' => $this->currentPage,

            'endPage' => min($this->lastPage, $this->currentPage + 2),

            'pageCount' => $this->lastPage,
        ];

        if ($this->currentPage - 1 >= 1) {
            $data['previous'] = $this->currentPage - 1;
        }

        if ($this->currentPage + 1 <= $this->lastPage) {
            $data['next'] = $this->currentPage + 1;
        }

        return $data;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }
}
