<?php
/**
 * User: huangyugui
 * Date: 16/5/10 09:36
 */

namespace App\Library;

use Illuminate\Pagination\LengthAwarePaginator;

class PageLibrary {

    private $paginator;

    private $html;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Render the given paginator.
     *
     * @return \Illuminate\Contracts\Support\Htmlable|string
     */
    public function render()
    {
        $this->htmlPage();
        return $this->html;
    }

    public function htmlPage()
    {
        $this->html .= '<ul class="pagination pagination-sm no-margin pull-right">';
        $this->html .= '<li class="paginate_button previous disabled"><a href="javascript:void(0);">共'.$this->paginator->total().'条</a></li>';
        $this->html .= '<li class="paginate_button previous disabled"><a href="javascript:void(0);">共 '.
            $this->paginator->lastPage().' 页</a></li>';
        if ($this->paginator->currentPage() == 1) {
            $this->html .= '<li class="paginate_button previous disabled"><a href="javascript:void(0);">首页</a></li>';
            $this->html .= '<li class="paginate_button previous disabled"><a href="javascript:void(0);">上一页</a></li>';
        } else {
            $this->html .= '<li class="paginate_button previous"><a href="'.
                ($this->buildUrl(1)).'">首页</a></li>';
            $this->html .= '<li class="paginate_button previous"><a href="'.
                $this->buildUrl($this->paginator->currentPage()-1).'">上一页</a></li>';
        }

        $showPage = 5;
        if ($this->paginator->lastPage() < $showPage) {
            $for = 1;
            $forEnd = $this->paginator->lastPage();
        } else {
            $middle = floor($showPage / 2);
            if ($this->paginator->currentPage() <= $middle) {
                $for = 1;
                $forEnd = $showPage;
            } else if (($this->paginator->lastPage() - $this->paginator->currentPage()) < $middle){
                $for = $this->paginator->lastPage() - $showPage + 1;
                $forEnd = $this->paginator->lastPage();
            } else {
                $for = $this->paginator->currentPage() - $middle;
                $forEnd = $this->paginator->currentPage() + $middle;
            }
        }
        for($i = $for; $i <= $forEnd; $i++) {
            $this->html .= '<li class="paginate_button '.($this->paginator->currentPage() == $i ?'active' : '')
                .'"><a href="'.$this->buildUrl($i).'">'.$i.'</a></li>';
        }

        if ($this->paginator->currentPage() == $this->paginator->lastPage()) {
            $this->html .= '<li class="paginate_button previous disabled"><a href="javascript:void(0);">下一页</a></li>';
            $this->html .= '<li class="paginate_button previous disabled"><a href="javascript:void(0);">尾页</a></li>';
        } else {
            $this->html .= '<li class="paginate_button previous">'
                .'<a href="'.$this->buildUrl($this->paginator->currentPage()+1).'">下一页</a></li>';

            $this->html .= '<li class="paginate_button previous">'
                .'<a href="'.$this->buildUrl($this->paginator->lastPage()).'">尾页</a></li>';
        }
        $this->html .= '<li class="paginate_button previous next">';
        $this->html .= '<span style="padding: 4px 5px;">';
        $this->html .= '<select onchange="goPage(this);">';
        for ($i = 1; $i <= $this->paginator->lastPage(); $i++) {
            $this->html .= '<option data="'.$this->buildUrl($i).'"';
            if($this->paginator->currentPage() == $i) {
                $this->html .= ' selected ';
            }
            $this->html .= ">".$i.'</option>';
        }
        $this->html .= '<script>function goPage(t){window.location.href = $(t).find("option:selected").attr("data");}</script>';
        $this->html .= '</select>';
        $this->html .= '</span>';
        $this->html .= '</li>';
        $this->html .= '</ul>';
    }

    public function buildUrl($int){
        $urlQuery = request()->query();
        $urlQuery['page'] = $int;
        return request()->url().'?'.http_build_query($urlQuery);
    }
}