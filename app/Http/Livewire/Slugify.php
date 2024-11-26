<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Slugify extends Component
{
    public $title;

    public $slug;

    public $src;

    public $emt;

    public function mount($src, $emt)
    {
        $this->src = $src;
        $this->emt = $emt;
        $this->title = $src['default'] ?? null;
        $this->slug = $emt['default'] ?? null;
        if (is_null($this->slug) || empty($this->slug)) {
            $this->slugify();
        }
    }

    public function slugify()
    {
        $slug = $this->title;
        $slug = strtolower($slug);
        $slug = preg_replace('/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/i', 'a', $slug);
        $slug = preg_replace('/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/i', 'o', $slug);
        $slug = preg_replace('/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/i', 'e', $slug);
        $slug = preg_replace('/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/i', 'u', $slug);
        $slug = preg_replace('/đ/i', 'd', $slug);
        $slug = preg_replace('/\@/', '-at-', $slug);
        $slug = preg_replace('/\&/', '-and-', $slug);
        $slug = preg_replace('/\#/', '-hash-', $slug);
        $slug = preg_replace('/\./', '-dot-', $slug);
        $slug = preg_replace('/\$/', '-dollar-', $slug);
        $slug = preg_replace('/\^/', '-carret-', $slug);
        $slug = preg_replace('/\+/', '-plus-', $slug);
        $slug = preg_replace('/\=/', '-equal-', $slug);
        $slug = preg_replace('/[\[\](){}%~`!""\'\':;\/\\?,<>]/', '', $slug);
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('/\s*$/', '', $slug);
        $slug = preg_replace('/^\s*/', '', $slug);

        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.slugify');
    }
}
