<?php

use Cycle\Annotated;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Schema;
use Cycle\ORM;
use Cycle\Database\DatabaseManager;
use Cycle\Database\Config\DatabaseConfig;
use Dotenv\Dotenv;
use Spiral\Tokenizer\ClassLocator;
use Symfony\Component\Finder\Finder;
use Cycle\Annotated\Locator\TokenizerEntityLocator;
use Cycle\Database\Config\Postgres\DsnConnectionConfig;
use Cycle\Annotated\Locator\TokenizerEmbeddingLocator;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$dbConfig = new DatabaseConfig([
    'default' => 'default',
    'databases' => [
        'default' => [
            'connection' => 'pgsql'
        ],
    ],
    'connections' => [
        'pgsql' => new PostgresDriverConfig(
            connection: new DsnConnectionConfig(
                dsn: sprintf(
                    'pgsql:host=%s;port=%s;dbname=%s',
                    $_ENV['POSTGRES_HOST'],
                    $_ENV['POSTGRES_PORT'],
                    $_ENV['POSTGRES_DB']
                ),
                user: $_ENV['POSTGRES_USER'],
                password: $_ENV['POSTGRES_PASSWORD'],
            ),
            queryCache: true
        ),
    ],
]);

$dbal = new DatabaseManager($dbConfig);

$finder = (new Finder())->files()->in([__DIR__ . '/../src']);
$classLocator = new ClassLocator($finder);


$embeddingLocator = new TokenizerEmbeddingLocator($classLocator);
$entityLocator = new TokenizerEntityLocator($classLocator);

$schema = (new Schema\Compiler())->compile(new Schema\Registry($dbal), [
    new Schema\Generator\ResetTables(),             // Reconfigure table schemas (deletes columns if necessary)
    new Annotated\Embeddings($embeddingLocator),    // Recognize embeddable entities
    new Annotated\Entities($entityLocator),         // Identify attributed entities
    new Annotated\TableInheritance(),               // Setup Single Table or Joined Table Inheritance
    new Annotated\MergeColumns(),                   // Integrate table #[Column] attributes
    new Schema\Generator\GenerateRelations(),       // Define entity relationships
    new Schema\Generator\GenerateModifiers(),       // Apply schema modifications
    new Schema\Generator\ValidateEntities(),        // Ensure entity schemas adhere to conventions
    new Schema\Generator\RenderTables(),            // Create table schemas
    new Schema\Generator\RenderRelations(),         // Establish keys and indexes for relationships
    new Schema\Generator\RenderModifiers(),         // Implement schema modifications
    new Schema\Generator\ForeignKeys(),             // Define foreign key constraints
    new Annotated\MergeIndexes(),                   // Merge table index attributes
    new Schema\Generator\SyncTables(),              // Align table changes with the database
    new Schema\Generator\GenerateTypecast(),        // Typecast non-string columns
]);

$orm = new ORM\ORM(new ORM\Factory($dbal), new ORM\Schema($schema));
return $orm;
