<?php

namespace Appzcoder\CrudGenerator\Commands;

use File;
use Illuminate\Console\Command;

class CrudViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:view
                            {name : The name of the Crud.}
                            {--fields= : The fields name for the form.}
                            {--view-path= : The name of the view path.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create views for the Crud.';

    /**
     *  Form field types collection.
     *
     * @var array
     */
    protected $typeLookup = [
        'string' => 'text',
        'char' => 'text',
        'varchar' => 'text',
        'text' => 'textarea',
        'mediumtext' => 'textarea',
        'longtext' => 'textarea',
        'json' => 'textarea',
        'jsonb' => 'textarea',
        'binary' => 'textarea',
        'password' => 'password',
        'email' => 'email',
        'number' => 'number',
        'integer' => 'number',
        'bigint' => 'number',
        'mediumint' => 'number',
        'tinyint' => 'number',
        'smallint' => 'number',
        'decimal' => 'number',
        'double' => 'number',
        'float' => 'number',
        'date' => 'date',
        'datetime' => 'datetime-local',
        'time' => 'time',
        'boolean' => 'radio',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $crudName = strtolower($this->argument('name'));
        $crudNameCap = ucwords($crudName);
        $crudNameSingular = str_singular($crudName);
        $crudNameSingularCap = ucwords($crudNameSingular);
        $crudNamePlural = str_plural($crudName);
        $crudNamePluralCap = ucwords($crudNamePlural);

        $viewDirectory = base_path('resources/views/');
        if ($this->option('view-path')) {
            $userPath = $this->option('view-path');
            $path = $viewDirectory . $userPath . '/' . $crudName . '/';
        } else {
            $path = $viewDirectory . $crudName . '/';
        }

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $fields = $this->option('fields');
        $fieldsArray = explode(',', $fields);

        $formFields = array();
        $x = 0;
        foreach ($fieldsArray as $item) {
            $itemArray = explode(':', $item);
            $formFields[$x]['name'] = trim($itemArray[0]);
            $formFields[$x]['type'] = trim($itemArray[4]);
            $formFields[$x]['label'] = trim($itemArray[3]);
            $formFields[$x]['required'] = (isset($itemArray[2]) && (trim($itemArray[2]) == 'req' || trim($itemArray[2]) == 'required')) ? true : false;

            $x++;
        }

        $formFieldsHtml = '';
        foreach ($formFields as $item) {
            $formFieldsHtml .= $this->createField($item);
        }

        // Form fields and label
        $formHeadingHtml = '';
        $formBodyHtml = '';
        $formBodyHtmlForShowView = '';

        $i = 0;
         foreach ($formFields as $key => $value) {
            $fieldShow = $value['name'];
            $labelShow = ucwords(str_replace('_', ' ', $value['label']));
            $formBodyHtmlForShowView .= '
                                <tr>
                                    <td width="30%">' . $labelShow . '</td> 
                                    <td>{!! $%%crudNameSingular%%->' . $fieldShow . ' !!}</td> 
                                </tr>';
        };

        foreach ($formFields as $key => $value) {
            if ($i == 3) {
                break;
            }

            $field = $value['name'];
            $label = ucwords(str_replace('_', ' ', $value['label']));
            $formHeadingHtml .= '
                                    <th>' . $label . '</th>';

            if ($i == 0) {
                $formBodyHtml .= '
                                    <td><a href="{{ url(\'/panelarea/%%crudName%%\', $item->id) }}">{!! $item->' . $field . ' !!}</a></td>';
            } else {
                $formBodyHtml .= '
                                    <td>{!! $item->' . $field . ' !!}</td>';
            }

            $i++;
        }

        // For index.blade.php file
        $indexFile = __DIR__ . '/../stubs/index.blade.stub';
        $newIndexFile = $path . 'index.blade.php';
        if (!File::copy($indexFile, $newIndexFile)) {
            echo "failed to copy $indexFile...\n";
        } else {
            File::put($newIndexFile, str_replace('%%formHeadingHtml%%', $formHeadingHtml, File::get($newIndexFile)));
            File::put($newIndexFile, str_replace('%%formBodyHtml%%', $formBodyHtml, File::get($newIndexFile)));
            File::put($newIndexFile, str_replace('%%crudName%%', $crudName, File::get($newIndexFile)));
            File::put($newIndexFile, str_replace('%%crudNameCap%%', $crudNameCap, File::get($newIndexFile)));
            File::put($newIndexFile, str_replace('%%crudNamePlural%%', $crudNamePlural, File::get($newIndexFile)));
            File::put($newIndexFile, str_replace('%%crudNamePluralCap%%', $crudNamePluralCap, File::get($newIndexFile)));
        }


        // For create.blade.php file
        $createFile = __DIR__ . '/../stubs/create.blade.stub';
        $newCreateFile = $path . 'create.blade.php';
        if (!File::copy($createFile, $newCreateFile)) {
            echo "failed to copy $createFile...\n";
        } else {
            File::put($newCreateFile, str_replace('%%crudName%%', $crudName, File::get($newCreateFile)));
            File::put($newCreateFile, str_replace('%%crudNameSingularCap%%', $crudNameSingularCap, File::get($newCreateFile)));
            File::put($newCreateFile, str_replace('%%formFieldsHtml%%', $formFieldsHtml, File::get($newCreateFile)));
            File::put($newCreateFile, str_replace('%%crudNamePluralCap%%', $crudNamePluralCap, File::get($newCreateFile)));
        }

        // For edit.blade.php file
        $editFile = __DIR__ . '/../stubs/edit.blade.stub';
        $newEditFile = $path . 'edit.blade.php';
        if (!File::copy($editFile, $newEditFile)) {
            echo "failed to copy $editFile...\n";
        } else {
            File::put($newEditFile, str_replace('%%crudName%%', $crudName, File::get($newEditFile)));
            File::put($newEditFile, str_replace('%%crudNameSingular%%', $crudNameSingular, File::get($newEditFile)));
            File::put($newEditFile, str_replace('%%crudNameSingularCap%%', $crudNameSingularCap, File::get($newEditFile)));
            File::put($newEditFile, str_replace('%%formFieldsHtml%%', $formFieldsHtml, File::get($newEditFile)));
            File::put($newEditFile, str_replace('%%crudNameCap%%', $crudNameCap, File::get($newEditFile)));
            File::put($newEditFile, str_replace('%%crudNamePluralCap%%', $crudNamePluralCap, File::get($newEditFile)));
        }

        // For show.blade.php file
        $showFile = __DIR__ . '/../stubs/show.blade.stub';
        $newShowFile = $path . 'show.blade.php';
        if (!File::copy($showFile, $newShowFile)) {
            echo "failed to copy $showFile...\n";
        } else {
            File::put($newShowFile, str_replace('%%formHeadingHtml%%', $formHeadingHtml, File::get($newShowFile)));
            File::put($newShowFile, str_replace('%%formBodyHtml%%', $formBodyHtmlForShowView, File::get($newShowFile)));
            File::put($newShowFile, str_replace('%%crudNameSingular%%', $crudNameSingular, File::get($newShowFile)));
            File::put($newShowFile, str_replace('%%crudNameSingularCap%%', $crudNameSingularCap, File::get($newShowFile)));
            File::put($newShowFile, str_replace('%%crudName%%', $crudName, File::get($newShowFile)));
        }

        // For layouts/master.blade.php file
        $layoutsDirPath = base_path('resources/views/layouts/');
        if (!File::isDirectory($layoutsDirPath)) {
            File::makeDirectory($layoutsDirPath);
        }

        $layoutsFile = __DIR__ . '/../stubs/master.blade.stub';
        $newLayoutsFile = $layoutsDirPath . 'master.blade.php';

        if (!File::exists($newLayoutsFile)) {
            if (!File::copy($layoutsFile, $newLayoutsFile)) {
                echo "failed to copy $layoutsFile...\n";
            }
        }

        $this->info('View created successfully.');
    }

    /**
     * Form field wrapper.
     *
     * @param  $item
     * @param  $field
     *
     * @return void
     */
    protected function wrapField($item, $field)
    {
        $formGroup =
            <<<EOD
                            <div class="form-group {{ \$errors->has('%1\$s') ? 'has-error' : ''}}">
                                {!! Form::label('%1\$s', '%2\$s: ', ['class' => 'col-sm-12']) !!}
                                <div class="col-sm-12">
                                    %3\$s
                                    {!! \$errors->first('%1\$s', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>\n
EOD;

        return sprintf($formGroup, $item['name'], ucwords(strtolower(str_replace('_', ' ', $item['label']))), $field);
    }

    /**
     * Form field generator.
     *
     * @param $item
     *
     * @return string
     */
    protected function createField($item)
    {
        switch ($item['type']) {
            case 'datepicker':
            case 'time':
                return $this->createDatepickerField($item);
                break;
            case 'textarea': //special
                return $this->createTextareaField($item);
                break;
            case 'texteditor': //special
                return $this->createTexteditorField($item);
                break;
            case 'select': //special
                return $this->createSelectField($item);
                break;
            case 'multipleselect': //special
                return $this->createMultipleselectField($item);
                break;
            case 'checkbox': //special
                return $this->createCheckboxField($item);
                break;
            case 'radio': //special
                return $this->createRadioField($item);
                break;
            case 'File': //special
                return $this->createFileField($item);
                break;
            default: // text
                return $this->createFormField($item);
        }
    }


    protected function createFormField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return $this->wrapField(
            $item,
            "<div class=\"input-group\">
                                        <span class=\"input-group-addon\">
                                            <span class=\"fa fa-pencil\"></span>
                                        </span>
                                        {!! Form::" . $item['type'] . "('" . $item['name'] . "', null, ['class' => 'form-control'$required]) !!}
                                    </div>"
        );
    }
    protected function createFileField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return $this->wrapField(
            $item,
            "{!! Form::file('" . $item['name'] . "', ['class' => 'fileinput btn-primary', 'title' => 'Browse file'$required]) !!}"
        );
    }
  
    protected function createCheckboxField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return "                <div class=\"form-group\">
                                    <div class=\"col-md-4\">
                                        <label class=\"check\">
                                            {!! Form::" . $item['type'] . "('" . $item['name'] . "', 1, null, ['class' => 'icheckbox']) !!} ".$item['label']."
                                        </label>
                                    </div>
                                </div>";
    }
    protected function createMultipleselectField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return $this->wrapField(
            $item,
            "{!! Form::select('" . $item['name'] . "', [], null, ['multiple' => 'multiple', class' => 'form-control select'$required]) !!}"
        );
    }
    protected function createSelectField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return $this->wrapField(
            $item,
            "{!! Form::select('" . $item['name'] . "', [], null, ['class' => 'form-control select'$required]) !!}"
        );
    }

    protected function createTexteditorField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return $this->wrapField(
            $item,
            "{!! Form::textarea('" . $item['name'] . "', null, ['class' => 'form-control summernote'$required]) !!}"
        );
    }

    protected function createTextareaField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return $this->wrapField(
            $item,
            "{!! Form::" . $item['type'] . "('" . $item['name'] . "', null, ['class' => 'form-control'$required]) !!}"
        );
    }
    protected function createDatepickerField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";

        return $this->wrapField(
            $item,
            "<div class=\"input-group\">
                                        <span class=\"input-group-addon\">
                                            <span class=\"fa fa-calendar\"> </span>
                                        </span>
                                        {!! Form::" . $item['type'] . "('" . $item['name'] . "', null, ['class' => 'form-control datepic'$required]) !!}
                                    </div>"
        );
    }

    protected function createInputField($item)
    {
        $required = ($item['required'] === true) ? ", 'required' => 'required'" : "";



        return $this->wrapField(
            $item,
            "<div class=\"input-group\">
                                        <span class=\"input-group-addon\">
                                            <span class=\"fa fa-pencil\"></span>
                                        </span>
                                        {!! Form::input('" . $this->typeLookup[$item['type']] . "', '" . $item['name'] . "', null, ['class' => 'form-control'$required]) !!}
                            </div>"
        );
    }

    protected function createRadioField($item)
    {
        $field =
            <<<EOD
                            <div class="checkbox">
                                <label>{!! Form::radio('%1\$s', '1') !!} Yes</label>
                            </div>
                            <div class="checkbox">
                                <label>{!! Form::radio('%1\$s', '0', true) !!} No</label>
                            </div>
EOD;

        return $this->wrapField($item, sprintf($field, $item['name']));
    }

}
