<?php
//Composer
require '/home/mguirao/aws/vendor/autoload.php';

//En la sección de IAM creen un nuevo usuario
$AccessKeyID = '';
$SecretAccessKey = '';
//include '/home/mguirao/.aws/AWS_Creds.php';

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\DynamoDbClient;
//use Aws\Common\Credentials\Credentials;

//$credentials = new Credentials('AKIAIUBLFZRV2ZN2Z3WQ', 'ZNofAo1mUeUpHVcSgfUml85p/m5bFRSDWPsAjlud');

$params = [
    'TableName' => 'Movies',
    'KeySchema' => [
        [
            'AttributeName' => 'year',
            'KeyType' => 'HASH'  //Partition key
        ],
        [
            'AttributeName' => 'title',
            'KeyType' => 'RANGE'  //Sort key
        ]
    ],
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'year',
            'AttributeType' => 'N'
        ],
        [
            'AttributeName' => 'title',
            'AttributeType' => 'S'
        ],

    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 10,
        'WriteCapacityUnits' => 10
    ]
];

$client = DynamoDbClient::factory(array(
    'credentials' => array(
        'key'    => $AccessKeyID,
        'secret' => $SecretAccessKey
    ),
    'region' => 'us-west-2',
    'version' => 'latest',
    'scheme' => 'https'
));

try {
    $result = $client->createTable($params);
    echo 'Created table.  Status: ' . 
        $result['TableDescription']['TableStatus'] ."\n";

} catch (DynamoDbException $e) {
    echo "Unable to create table:\n";
    echo $e->getMessage() . "\n";
}



?>