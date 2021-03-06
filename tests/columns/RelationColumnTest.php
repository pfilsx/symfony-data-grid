<?php


namespace Pfilsx\DataGrid\tests\columns;


use Pfilsx\DataGrid\Grid\Columns\RelationColumn;
use Pfilsx\DataGrid\Grid\Items\EntityGridItem;
use Pfilsx\tests\OrmTestCase;

/**
 * @property RelationColumn testColumn
 */
class RelationColumnTest extends OrmTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->testColumn = new RelationColumn($this->serviceContainer, [
            'attribute' => 'test_attribute',
            'labelAttribute' => 'title',
            'format' => 'html',
            'label' => 'test',
            'template' => 'test_template.html.twig'
        ]);
    }

    public function testCheckConfiguration(): void
    {
        $column = new RelationColumn($this->serviceContainer, [
            'attribute' => 'test_attribute',
            'template' => 'test_template.html.twig'
        ]);
        $this->assertEquals('id', $column->getLabelAttribute());
    }

    public function testGetHeadContent(): void
    {
        $this->assertEquals('Test', $this->testColumn->getHeadContent());
        $column = new RelationColumn($this->serviceContainer, ['attribute' => 'testAttribute', 'labelAttribute' => 'title']);
        $this->assertEquals('TestAttribute.title', $column->getHeadContent());
    }

    public function testGetCellContent(): void
    {
        $entity = new class
        {
            public function getTestAttribute()
            {
                return new class
                {
                    public function getTitle()
                    {
                        return 'test_data';
                    }
                };
            }
        };
        $item = new EntityGridItem($entity);
        $this->assertEquals('test_data', $this->testColumn->getCellContent($item));

        $item->setData(new class
        {
            public function getTestAttribute()
            {
                return null;
            }
        });
        $this->assertEquals('', $this->testColumn->getCellContent($item));
    }
}
