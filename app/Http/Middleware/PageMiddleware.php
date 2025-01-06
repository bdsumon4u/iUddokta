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

        if (str_contains((string) $content, '[!PAGE_TITLE]')) {
            $content = str_replace('[!PAGE_TITLE]', '', $content);
            $content = preg_replace("~<h2\sclass=\"section-title\">.*?</h2>~", '', $content);
        }

        if (str_contains((string) $content, '[CONTACT_FORM]')) {
            $content = str_replace(
                '[CONTACT_FORM]',
                View::make('contact-form'),
                $content
            );
        }
        if (str_contains((string) $content, '[FAQs]')) {
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
