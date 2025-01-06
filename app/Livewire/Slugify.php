<?php

namespace App\Livewire;

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
        $slug = strtolower((string) $slug);
        $slug = preg_replace('/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/i', 'a', $slug);
        $slug = preg_replace('/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/i', 'o', (string) $slug);
        $slug = preg_replace('/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/i', 'e', (string) $slug);
        $slug = preg_replace('/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/i', 'u', (string) $slug);
        $slug = preg_replace('/đ/i', 'd', (string) $slug);
        $slug = preg_replace('/\@/', '-at-', (string) $slug);
        $slug = preg_replace('/\&/', '-and-', (string) $slug);
        $slug = preg_replace('/\#/', '-hash-', (string) $slug);
        $slug = preg_replace('/\./', '-dot-', (string) $slug);
        $slug = preg_replace('/\$/', '-dollar-', (string) $slug);
        $slug = preg_replace('/\^/', '-carret-', (string) $slug);
        $slug = preg_replace('/\+/', '-plus-', (string) $slug);
        $slug = preg_replace('/\=/', '-equal-', (string) $slug);
        $slug = preg_replace('/[\[\](){}%~`!""\'\':;\/\\?,<>]/', '', (string) $slug);
        $slug = preg_replace('/\s+/', '-', (string) $slug);
        $slug = preg_replace('/\s*$/', '', (string) $slug);
        $slug = preg_replace('/^\s*/', '', (string) $slug);

        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.slugify');
    }
}
