<?php namespace Tests\Unit\Repositories;

use App\Models\Tenant\Attribute;
use App\Repositories\AttributeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttributeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AttributeRepository
     */
    protected $attributeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->attributeRepo = \App::make(AttributeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attribute()
    {
        $attribute = factory(Attribute::class)->make()->toArray();

        $createdAttribute = $this->attributeRepo->create($attribute);

        $createdAttribute = $createdAttribute->toArray();
        $this->assertArrayHasKey('id', $createdAttribute);
        $this->assertNotNull($createdAttribute['id'], 'Created Attribute must have id specified');
        $this->assertNotNull(Attribute::find($createdAttribute['id']), 'Attribute with given id must be in DB');
        $this->assertModelData($attribute, $createdAttribute);
    }

    /**
     * @test read
     */
    public function test_read_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $dbAttribute = $this->attributeRepo->find($attribute->id);

        $dbAttribute = $dbAttribute->toArray();
        $this->assertModelData($attribute->toArray(), $dbAttribute);
    }

    /**
     * @test update
     */
    public function test_update_attribute()
    {
        $attribute = factory(Attribute::class)->create();
        $fakeAttribute = factory(Attribute::class)->make()->toArray();

        $updatedAttribute = $this->attributeRepo->update($fakeAttribute, $attribute->id);

        $this->assertModelData($fakeAttribute, $updatedAttribute->toArray());
        $dbAttribute = $this->attributeRepo->find($attribute->id);
        $this->assertModelData($fakeAttribute, $dbAttribute->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $resp = $this->attributeRepo->delete($attribute->id);

        $this->assertTrue($resp);
        $this->assertNull(Attribute::find($attribute->id), 'Attribute should not exist in DB');
    }
}
