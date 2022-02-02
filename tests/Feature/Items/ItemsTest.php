<?php

namespace Tests\Feature\Items;

use Tests\TestCase;

class ItemsTest extends TestCase
{
    /**
     * @var string
     */
    protected string $endpoint = 'items';

    /**
     * A basic test countries.
     *
     * @return void
     */
    public function test_items()
    {
        $this->getHttpMethod();
    }

    /**
     * A basic test countries.
     *
     * @return void
     */
    public function test_products_relations()
    {
        $this->getHttpMethodWithRelations();
    }

    /**
     * A basic test countries.
     *
     * @return void
     */
    public function test_items_post_required_columns()
    {
        $this->postRequiredColumns();
    }

    /**
     * A basic test countries.
     *
     * @return void
     */
    public function test_items_post()
    {
        $this->postHttpMethod();
    }

    /**
     * A basic test countries.
     *
     * @return void
     */
    public function test_items_put()
    {
        $this->putHttpMethod();
    }
}
