<?php

namespace Appzcoder\CrudGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudMigrationCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:migration
                            {name : The name of the migration.}
                            {--schema= : The name of the schema.}
                            {--pk=id : The name of the primary key.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/migration.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = strtolower(str_replace($this->laravel->getNamespace(), '', $name));
        $datePrefix = date('Y_m_d_His');

        return database_path('/migrations/') . $datePrefix . '_create_' . $name . '_table.php';
    }

    /**
     * Build the model class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $tableName = strtolower($this->argument('name'));
        $className = 'Create' . ucwords($tableName) . 'Table';

        $schema = $this->option('schema');
        $fields = explode(',', $schema);

        $data = array();
        $x = 0;
        foreach ($fields as $field) {
            $fieldArray = explode(':', $field);
            $data[$x]['name'] = trim($fieldArray[0]);
            $data[$x]['type'] = trim($fieldArray[1]);
            $data[$x]['nullable'] = (isset($fieldArray[6]) && (trim($fieldArray[6]) == 'nullable' || trim($fieldArray[6]) == 'null')) ? "->nullable()" : "";
            $data[$x]['length'] = (isset($fieldArray[5]) && (trim($fieldArray[5]) != '')) ? ", ".trim($fieldArray[5]) : "";
            $data[$x]['unsigned'] = (isset($fieldArray[7]) && (trim($fieldArray[7]) == 'unsigned')) ? "->unsigned()" : "";

            $data[$x]['default'] = (isset($fieldArray[8]) && (trim($fieldArray[8]) != '')) ? "->default('".trim($fieldArray[8])."')" : "";
            $x++;
        }

        $schemaFields = '';
        foreach ($data as $item) {
            switch ($item['type']) {
                case 'char':
                    $schemaFields .= "                \$table->char('" . $item['name']."'" . $item['length'].")".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'date':
                    $schemaFields .= "                \$table->date('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'datetime':
                    $schemaFields .= "                \$table->dateTime('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'time':
                    $schemaFields .= "                \$table->time('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'timestamp':
                    $schemaFields .= "                \$table->timestamp('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'text':
                    $schemaFields .= "                \$table->text('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'mediumtext':
                    $schemaFields .= "                \$table->mediumText('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'longtext':
                    $schemaFields .= "                \$table->longText('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'json':
                    $schemaFields .= "                \$table->json('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'jsonb':
                    $schemaFields .= "                \$table->jsonb('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'binary':
                    $schemaFields .= "                \$table->binary('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'number':
                case 'integer':
                    $schemaFields .= "                \$table->integer('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'bigint':
                    $schemaFields .= "                \$table->bigInteger('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'mediumint':
                    $schemaFields .= "                \$table->mediumInteger('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'tinyint':
                    $schemaFields .= "                \$table->tinyInteger('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'smallint':
                    $schemaFields .= "                \$table->smallInteger('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'boolean':
                    $schemaFields .= "                \$table->boolean('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'decimal':
                    $itemlength = '';
                    $itemlength = ($item['length'] != "") ? str_replace('.', ',', $item['length']) : "";
                    $schemaFields .= "                \$table->decimal('" . $item['name'] ."'". $itemlength. ")".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'double':
                    $itemlength = '';
                    $itemlength = ($item['length'] != "") ? str_replace('.', ',', $item['length']) : "";
                    $schemaFields .= "                \$table->double('" . $item['name'] ."'". $itemlength. ")".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                case 'float':
                    $schemaFields .= "                \$table->float('" . $item['name'] . "')".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;

                default:
                    $schemaFields .= "                \$table->string('" . $item['name'] ."'". $item['length']. ")".$item['nullable'].$item['default'].$item['unsigned'].";\n";
                    break;
            }
        }

        $primaryKey = strtolower($this->option('pk'));
        $forKey = $this->option('pk');

        $pkArray = explode(':', $forKey);
        $foreign = (isset($pkArray[2]) && (trim($pkArray[2]) != '')) ? $pkArray[2] : null;
        $foreignkey = "";
        if (!is_null($foreign)) {
            $keyArray = explode(',', $foreign);
            foreach ($keyArray as $fkey) {
                $fkeyArray = explode('#', $fkey);
                $foreignkey .= "
                \$table->index('".$fkeyArray[1]."');
                \$table->foreign('".$fkeyArray[1]."')->references('".$fkeyArray[3]."')->on('".$fkeyArray[2]."')->onDelete('".$fkeyArray[5]."')->onUpdate('".$fkeyArray[4]."');";
            }
        }

        $schemaUp = "
            Schema::create('" . $tableName . "', function(Blueprint \$table) {
                \$table->".$pkArray[1]."('" . $pkArray[0] . "');\n" . $schemaFields . "
                \$table->string('slug', 100)->unique();
                \$table->tinyInteger('isactive')->default(1);
                \$table->timestamps();\n

                ".$foreignkey."
            });
            ";

        $schemaDown = "Schema::drop('" . $tableName . "');";

        return $this->replaceSchemaUp($stub, $schemaUp)
            ->replaceSchemaDown($stub, $schemaDown)
            ->replaceClass($stub, $className);
    }

    /**
     * Replace the schema_up for the given stub.
     *
     * @param  string  $stub
     * @return $this
     */
    protected function replaceSchemaUp(&$stub, $schemaUp)
    {
        $stub = str_replace(
            '{{schema_up}}', $schemaUp, $stub
        );

        return $this;
    }

    /**
     * Replace the schema_down for the given stub.
     *
     * @param  string  $stub
     * @return $this
     */
    protected function replaceSchemaDown(&$stub, $schemaDown)
    {
        $stub = str_replace(
            '{{schema_down}}', $schemaDown, $stub
        );

        return $this;
    }

}
