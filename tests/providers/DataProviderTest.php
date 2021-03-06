<?php


namespace Pfilsx\tests\providers;


use Pfilsx\DataGrid\DataGridException;
use Pfilsx\DataGrid\Grid\Providers\ArrayDataProvider;
use Pfilsx\DataGrid\Grid\Providers\DataProvider;
use Pfilsx\DataGrid\Grid\Providers\QueryBuilderDataProvider;
use Pfilsx\DataGrid\Grid\Providers\RepositoryDataProvider;
use Pfilsx\tests\app\Entity\Node;
use Pfilsx\tests\OrmTestCase;


class DataProviderTest extends OrmTestCase
{
    public function testCreate(): void
    {
        $repository = $this->getEntityManager()->getRepository(Node::class);
        $provider1 = DataProvider::create($repository, $this->serviceContainer->getDoctrine());
        $this->assertInstanceOf(RepositoryDataProvider::class, $provider1);

        $qb = $repository->createQueryBuilder('qb1');
        $provider2 = DataProvider::create($qb, $this->serviceContainer->getDoctrine());
        $this->assertInstanceOf(QueryBuilderDataProvider::class, $provider2);

        $provider3 = DataProvider::create([], $this->serviceContainer->getDoctrine());
        $this->assertInstanceOf(ArrayDataProvider::class, $provider3);

        $this->expectException(DataGridException::class);
        DataProvider::create('', $this->serviceContainer->getDoctrine());
    }
}
