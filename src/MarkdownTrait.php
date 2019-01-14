<?php
namespace Oliver;

trait MarkdownTrait {
    public function markdown(string $text) : string
    {
        return $this->di->get("textfilter")->doFilter($text, "markdown");
    }
}
