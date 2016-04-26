<?php
//Composer
require '/home/mguirao/aws/vendor/autoload.php';

//En la sección de IAM creen un nuevo usuario
$AccessKeyID = 'AKIAIG6GRFKIS2YL7FGQ';
$SecretAccessKey = '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';

//Importo mis clases, equivale al import en java
use Aws\S3\S3Client;
//Importar las excepciones
use Aws\S3\Exception\S3Exception;
use Aws\S3\Exception\BucketAlreadyOwnedByYou;

$bucketName = 'mayabmimegabucket994';//$_GET['bucketName'];
$bucketToDelete = $_GET['bucketToDelete'];
$nombre = $_GET['nombre'];
$contenido = $_GET['contenido'];


//Crear un cliente de S3
$clienteS3 = new S3Client([
    'version'     => 'latest',
    'region'      => 'us-west-2',
    'credentials' => [
        'key'    => $AccessKeyID,
        'secret' => $SecretAccessKey
    ]
]);

try{
	$result = $clienteS3->createBucket([
    	'ACL' => 'public-read-write',
    	'Bucket' => $bucketName // REQUIRED
	]);	
	echo "El Bucket [$bucketName] ha sido creado!<br>";
} catch(S3Exception $e){
	echo "An error ocurred while creating the bucket $bucketName!<br>";
	//echo $e->getMessage();
} catch(BucketAlreadyOwnedByYou $e){
	echo "El nombre del Bucket $bucketName no está disponible!<br>";
	echo $e->getMessage();
} 


//Guardamos el obejeto en un bucket por default.
guardarObjeto($nombre, $contenido);

//Lista todos los buckets creados
$result2 = $clienteS3->listBuckets();

echo "Your bucket(s):";

echo "<form action = aws.php method = POST>";
echo "<select name = 'bucketToDelete'>";
foreach ($result2['Buckets'] as $bucket) {
    echo "<option value = ".$bucket['Name'].">".$bucket['Name'] . "</option>";
}
echo "</select>";
echo "<input type = submit ></input>";
echo "</form>";

//Borramos un bucket
if (!(bucketName == null || bucketName == '')) {
	$result = $clienteS3->deleteBucket([
		'Bucket' => $bucketToDelete
		]);
	echo "Bucket $bucketToDelete deleted!";
}

function guardarObjeto($nombre, $contenido, $bucket = 'mayabmimegabucket979'){
	global $clienteS3;

	$result = $clienteS3->putObject([
	'Bucket' 	=> $bucket,
	'Key'		=> $nombre,
	'Body'		=> $contenido
	]);
	return 0;
}
?>