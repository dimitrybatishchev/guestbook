<?php

namespace View;

class Paginator {
    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range;
    var $low;
    var $high;
    var $limit;
    var $return;
    var $default_ipp = 25;

    private $mapper;

    /**
     * @param $mapper
     * @param $page
     * @param $itemsPerPage
     */
    public function __construct($mapper, $page, $itemsPerPage){
        $this->mapper = $mapper;
        $this->current_page = $page;
        $this->items_total = $this->mapper->getCount();
        $this->items_per_page = $itemsPerPage;
        $this->mid_range = 9;
    }

    /**
     * @return string
     */
    public function paginate()
    {
        if ($this->return){
            return $this->return;
        }

        $this->num_pages = ceil($this->items_total/$this->items_per_page);

        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;

        $this->return .= '<div class="pagination-centered"><ul class="pagination">';
        if($this->num_pages > 10)
        {
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<li><a class=\"paginate\" href=\"?page=$prev_page\">« Previous</a></li> ":"<li class=\"unavailable\"><span class=\"inactive\" href=\"#\">« Previous</span></li>";

            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);

            if($this->start_range <= 0)
            {
                $this->end_range += abs($this->start_range)+1;
                $this->start_range = 1;
            }
            if($this->end_range > $this->num_pages)
            {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }
            $this->range = range($this->start_range,$this->end_range);

            for($i=1;$i<=$this->num_pages;$i++)
            {
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                {
                    $this->return .= ($i == $this->current_page And $_GET['page'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"?page=$i\">$i</a> ";
                }
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
            }
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['page'] != 'All')) ? "<li><a class=\"paginate\" href=\"?page=$next_page&ipp=$this->items_per_page\">Next »</a></li>\n":"<span class=\"inactive\" href=\"#\">» Next</span>\n";
        } else {
            for($i=1;$i<=$this->num_pages;$i++){
                $this->return .= ($i == $this->current_page) ? "<li class=\"current\"><a href=\"#\">$i</a></li> ":"<li><a href=\"?page=$i\">$i</a></li> ";
            }
        }
        $this->low = ($this->current_page-1) * $this->items_per_page;
        $this->high = $this->items_per_page - 1;

        $this->return .= '</ul></div>';

        return $this->return;
    }

}
