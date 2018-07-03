<?php
namespace App\Repositories\Contracts;

interface PageRepositoryInterface
{
    public function all();
    public function getByID($page_id);
    public function getBySlug($slug);
}
