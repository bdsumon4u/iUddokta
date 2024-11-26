<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class PageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (! method_exists($response, 'content')) {
            return $response;
        }

        $content = $response->content();

        if (strpos($content, '[!PAGE_TITLE]') != false) {
            $content = str_replace('[!PAGE_TITLE]', '', $content);
            $content = preg_replace("~<h2\sclass=\"section-title\">.*?</h2>~", '', $content);
        }

        if (strpos($content, '[CONTACT_FORM]') != false) {
            $content = str_replace(
                '[CONTACT_FORM]',
                View::make('contact-form'),
                $content
            );
        }
        if (strpos($content, '[FAQs]') != false) {
            $content = str_replace(
                '[FAQs]',
                View::make('faqs'),
                $content
            );
        }

        $response->setContent($content);

        return $response;
    }
}
