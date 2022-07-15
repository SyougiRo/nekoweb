
<?php
    
    $manager = new MongoDB\Driver\Manager(); //連接資料庫

    $bulk = new MongoDB\Driver\BulkWrite; //新增,更改,刪除資料
    /*
    $query = new MongoDB\Driver\Query(['name' => '菜鸟教程']);
    $document = [ 'name' => '菜鸟教程']; //搜尋條件

    //$_id= $bulk->insert($document); //新增資料

    //var_dump($_id);

    
    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000); //操作的結果控制器
    //$result = $manager->executeBulkWrite('test.runoob', $bulk, $writeConcern);

    $cursor = $manager->executeQuery('test.runoob', $query); //搜尋資料

    foreach ($cursor as $document) {
        print_r($document);
    }

    $bulk->delete(['name' => '菜鸟教程']);
    $result = $manager->executeBulkWrite('test.runoob', $bulk, $writeConcern);
    print_r($result);
    */
    $cat_data = [
        'color'=>['red'=>0,'white'=>1,'black'=>1],
        'tnr'=>false
    ];
    //$query = new MongoDB\Driver\Query($cat_data);
    $_id= $bulk->insert($cat_data);
    var_dump($_id);

    $writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
    $result = $manager->executeBulkWrite('test.cat', $bulk, $writeConcern);
?>