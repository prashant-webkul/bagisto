<?php

namespace Webkul\Custom\Helpers;

use Webkul\Category\Repositories\CategoryRepository as Category;

use Webkul\CMS\Repositories\CMSRepository as CMS;

class CategorySeeder
{
    protected $category;

    protected $cms;

    public function __construct(Category $category, CMS $cms)
    {
        $this->category = $category;

        $this->cms = $cms;
    }

    public function handle($id)
    {
        try {
            $data = [
                'position' => '2',
                'image' => NULL,
                'status' => '1',
                'parent_id' => NULL,
                'name' => 'Test',
                'slug' => 'test',
                'description' => 'Test category',
                'meta_title' => 'Test Category',
                'meta_description' => 'Test category description',
                'meta_keywords' => 'test, category',
                'locale' => 'all'
            ];

            $this->category->create($data);

            // $contactPages = $this->cms->findWhere([
            //     'url_key' => 'contact-us'
            // ]);

            // foreach ($contactPages as $contactPage) {
            //     $contactPage->update([
            //         'url_key' => 'contact-us',
            //         'html_content' => '@include("custom::contact-form")',
            //         'page_title' => 'Contact Us',
            //         'meta_title' => 'Contact Us',
            //         'meta_description' => '',
            //         'meta_keywords' => 'contact, us',
            //         'content' => '{"html": "<div class=\"static-container one-column\">\r\n@include(\'custom::contact-form\')\r\n</div>",
            //                 "meta_title": "Contact Us",
            //                 "page_title": "Contact Us",
            //                 "meta_keywords": "contact, us ", "meta_description": ""}',
            //     ]);
            // }
        } catch (\Exception $e) {
        }
    }
}