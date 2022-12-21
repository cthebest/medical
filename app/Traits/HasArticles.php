<?php

namespace App\Traits;


trait HasArticles{
    
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}