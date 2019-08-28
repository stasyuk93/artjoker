<?php

namespace Library;


class Paginate
{
    protected $countPages;

    protected $countPerPage;

    protected $requestPage = "page";

    protected $currentPage;

    protected $startLink;

    protected $endLink;

    public function __construct($countPages, $countPerPage)
    {
        $this->countPages = $countPages;
        $this->countPerPage = $countPerPage;
        $this->setCurrentPage();
        $this->setStartEndLinks();
    }

    public function links()
    {
        return view('Templates/paginate',['paginate' => $this]);
    }

    public function getUrl($page)
    {
        return request()->getUrlWithParams([$this->requestPage => $page]);
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getStartLink()
    {
        return $this->startLink;
    }

    public function getEndLink()
    {
        return $this->endLink;
    }

    /**
     * @return int
     */
    public function getCountPages()
    {
        return $this->countPages;
    }

    /**
     * @return int
     */
    public function getCountPerPage()
    {
        return $this->countPerPage;
    }

    protected function setCurrentPage()
    {
        if(isset($_REQUEST[$this->requestPage])){
            $this->currentPage = (int) abs($_REQUEST[$this->requestPage]);
            if($this->currentPage == 0) $this->currentPage = 1;
        } else {
            $this->currentPage = 1;
        }
    }

    protected function setStartEndLinks()
    {
        if (($this->currentPage - 1) < floor($this->countPerPage / 2)) {
            $this->startLink = 1;
        } else {
            $this->startLink = $this->currentPage - floor($this->countPerPage / 2);
        }
        $this->endLink = $this->startLink + $this->countPerPage - 1;
        if ($this->endLink > $this->countPages) {
            $this->startLink -= ($this->endLink - $this->countPages);
            $this->endLink = $this->countPages;
            if ($this->startLink < 1) $this->startLink = 1;
        }
    }




}