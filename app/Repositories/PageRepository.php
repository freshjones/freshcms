<?php 

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\PageRepositoryInterface;
use App\Page;
use App\Content;

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
                'pages.publish_at',
                'pages.unpublish_at',
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
        return Content::with(['page' => function ($query) use ($slug) {
            $query->where('slug', $slug);
        }])->where('lang','en')->first();
        
        //$this->getOne('pages.slug',$slug);
    }

    public function all(){
        
        return $this->getAll('pages.display',1);

    }
}
