<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\AttributeOption;
use App\Repositories\AttributeOptionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttributeOptionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AttributeOptionRepository
     */
    protected $attributeOptionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->attributeOptionRepo = \App::make(AttributeOptionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->make()->toArray();

        $createdAttributeOption = $this->attributeOptionRepo->create($attributeOption);

        $createdAttributeOption = $createdAttributeOption->toArray();
        $this->assertArrayHasKey('id', $createdAttributeOption);
        $this->assertNotNull($createdAttributeOption['id'], 'Created AttributeOption must have id specified');
        $this->assertNotNull(AttributeOption::find($createdAttributeOption['id']), 'AttributeOption with given id must be in DB');
        $this->assertModelData($attributeOption, $createdAttributeOption);
    }

    /**
     * @test read
     */
    public function test_read_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->create();

        $dbAttributeOption = $this->attributeOptionRepo->find($attributeOption->id);

        $dbAttributeOption = $dbAttributeOption->toArray();
        $this->assertModelData($attributeOption->toArray(), $dbAttributeOption);
    }

    /**
     * @test update
     */
    public function test_update_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->create();
        $fakeAttributeOption = factory(AttributeOption::class)->make()->toArray();

        $updatedAttributeOption = $this->attributeOptionRepo->update($fakeAttributeOption, $attributeOption->id);

        $this->assertModelData($fakeAttributeOption, $updatedAttributeOption->toArray());
        $dbAttributeOption = $this->attributeOptionRepo->find($attributeOption->id);
        $this->assertModelData($fakeAttributeOption, $dbAttributeOption->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attribute_option()
    {
        $attributeOption = factory(AttributeOption::class)->create();

        $resp = $this->attributeOptionRepo->delete($attributeOption->id);

        $this->assertTrue($resp);
        $this->assertNull(AttributeOption::find($attributeOption->id), 'AttributeOption should not exist in DB');
    }
}
