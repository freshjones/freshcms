<?php 

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\PageRepositoryInterface;

class PageRepository implements PageRepositoryInterface
{

    private function getAll($param,$value)
    {
        return DB::table('pages')
            ->select(
                'pages.id',
                'pages.slug',
                'pages.display',
                'contents.lang',
                'contents.title',
                'contents.meta_description',
                'contents.meta_robot',
                'contents.content'
            )
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where($param, '=', $value)
            ->get();
    }

    private function getOne($param,$value)
    {
        return DB::table('pages')
            ->select(
                'pages.id',
                'pages.slug',
                'pages.display',
                'contents.lang',
                'contents.title',
                'contents.meta_description',
                'contents.meta_robot',
                'contents.content'
            )
            ->join('contents', function ($join) {
                $join->on('pages.id', '=', 'contents.page_id')->where('contents.lang', '=', "en");
            })
            ->where($param, '=', $value)
            ->first();
    }

    public function getByID($id)
    {
        return $this->getOne('pages.id',$id);
    }

    public function getBySlug($slug)
    {
        return $this->getOne('pages.slug',$slug);
    }

    public function all(){
        
        return $this->getAll('pages.display',1);

    }
}
