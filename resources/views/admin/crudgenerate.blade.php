@extends('admin.adminmaster')
@section('title', 'Create New CRUD')

@section('content')
 <!-- PAGE CONTENT --> 
    <!-- START BREADCRUMB -->
    <ul class="breadcrumb">
        <li><a href="{{ URL('/panelarea')}}">Dashboard</a></li>                 
        <li class="active">Create New CRUD</li>
    </ul>
    <!-- END BREADCRUMB -->  
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
    
        <div class="row">
            <div class="col-md-12">
                
                {!! Form::open(['url' => '/panelarea/crud-generate', 'class' => 'form-horizontal']) !!}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Create New</strong> CRUD</h3>
                    </div>
                    <div class="panel-body">
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                         {!! Form::label('command', 'Select a command : ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                            <div class="col-md-6 col-xs-12">   
                            {!! Form::select('command', ['crudcommand' => 'Crud generator command', 'controller' => 'Controller generator command', 'model' => 'Model generator command', 'migration' => 'Migration generator command', 'view' => 'View generator command'], null, ['class' => 'form-control select', 'required' => 'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Name: ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('namespace', 'Namespace: ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {!! Form::text('namespace', "Admin", ['class' => 'form-control']) !!}
                                </div>
                                <span class="help-block">Blank for default namespace</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('viewpath', 'View path: ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                    {!! Form::text('viewpath', 'admin', ['class' => 'form-control']) !!}
                                </div>
                                <span class="help-block">Blank for default path</span>
                            </div>
                        </div>
                        <div class="fieldgroup" id="fieldgroup"> 
                            <div class="field" id="field" style="margin-bottom: 10px;"> 
                                <div class="form-group">
                                    {!! Form::label('fieldName', 'Primary keys auto increments Field: ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                                    <div class="col-md-6 col-xs-12">                         
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            {!! Form::text('id[title]', 'id', ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div> 
                                    </div>
                                </div>
                                <div class="form-group fieldType">
                                     {!! Form::label('fieldType', 'Select a increment type : ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                                    <div class="col-md-6">    
                                        {!! Form::select('id[type]', ['increments' => 'increments','bigIncrements' => 'bigIncrements'], null, ['class' => 'form-control select']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-10">    
                                <button class="btn btn-info btn-rounded pull-right" onclick="addCrudField(this)" date-field-count="0" type="button">Add field</button>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('migrate', 'Run migrate command: ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                            <div class="col-md-6 col-xs-12">
                                <div class="input-group">
                                {!! Form::checkbox('migrate', 1, null, ['class' => 'icheckbox']) !!}
                                </div>
                            </div>
                        </div>
                        

                    </div>  
                    <div class="panel-footer">
                        <a class="btn btn-default" href="{{ URL('/panelarea')}}">Back</a>      
                         {!! Form::submit('Create', ['class' => 'btn btn-primary pull-right']) !!}
                    </div>  
                </div>
                {!! Form::close() !!}
                </div>
            </div>                    
            
        </div>
        <!-- END PAGE CONTENT WRAPPER -->
@endsection

@section('footer')
<script type="text/javascript">
/**********************addCrudField*****************************************/
    function addCrudField(thisfield){
        var fieldcount = parseInt($(thisfield).attr("date-field-count"));
        fieldcount = fieldcount + 1;
        $(thisfield).attr("date-field-count", fieldcount);

        var field='<div class="field" id="field'+fieldcount+'" style="padding: 10px 0px; border-top: 1px dashed rgb(204, 204, 204);"><span class="btn btn-danger btn-rounded curdfieldcount" type="button">'+fieldcount+'</span> <div class="form-group"> <label for="fieldName" class="col-md-3 col-xs-12 control-label">Label text: </label> <div class="col-md-6 col-xs-12"> <div class="input-group"> <span class="input-group-addon"><span class="fa fa-pencil"></span></span> <input class="form-control" required="required" name="fields['+fieldcount+'][label]" fieldcount="'+fieldcount+'" onkeyup="labeldbname(this)" onchange="labeldbname(this)" type="text"> </div> </div>  </div> <div class="form-group fieldType">  <label for="viewfieldType" class="col-md-3 col-xs-12 control-label">Select a field type : </label> <div class="col-md-6"> <select class="form-control select" name="fields['+fieldcount+'][fieldType]"><option value="text">Text Box</option><option value="textarea">Textarea</option><option value="texteditor">Text Editor</option><option value="select">Select box</option><option value="multipleselect">Multiple Select</option><option value="checkbox">Checkbox</option><option value="radio">Radio button</option><option value="File">File uploader</option><option value="datepicker">Datepicker</option> </select> </div> <div class="col-md-1"><div class="checkbox"><label><input type="checkbox" name="fields['+fieldcount+'][required]" value="required"/>Required </label></div></div> </div>  <div class="form-group"> <label for="fieldName" class="col-md-3 col-xs-12 control-label">DB Field Name: </label> <div class="col-md-6 col-xs-12"> <div class="input-group"> <span class="input-group-addon"><span class="fa fa-pencil"></span></span> <input class="form-control dbname'+fieldcount+'" required="required" name="fields['+fieldcount+'][name]" onkeyup="dbname(this)" type="text"> </div> </div>  </div> <div class="form-group fieldType">  <label for="fieldType" class="col-md-3 col-xs-12 control-label">Select a data type : </label> <div class="col-md-6"> <select class="form-control select" data-live-search="true" name="fields['+fieldcount+'][type]"><option value="string">string</option><option value="text">text</option><option value="integer">integer</option><option value="bigint">bigint</option><option value="tinyint">tinyint</option><option value="double">double</option><option value="float">float</option><option value="binary">binary</option><option value="boolean">boolean</option><option value="date">date</option><option value="datetime">datetime</option><option value="time">time</option><option value="timestamp">timestamp</option><option value="mediumtext">mediumtext</option><option value="longtext">longtext</option><option value="json">json</option><option value="jsonb">jsonb</option><option value="binary">binary</option><option value="number">number</option><option value="mediumint">mediumint</option><option value="smallint">smallint</option><option value="boolean">boolean</option><option value="decimal">decimal</option></select> </div> </div>   <div class="form-group fielddefault'+fieldcount+'"> <label for="fielddefault" class="col-md-3 col-xs-12 control-label">DB Field default: </label> <div class="col-md-6 col-xs-12"> <div class="input-group"> <span class="input-group-addon"><span class="fa fa-pencil"></span></span> <input class="form-control default'+fieldcount+'" name="fields['+fieldcount+'][default]" type="text"> </div></div>  </div><div class="form-group fieldlenght'+fieldcount+'"> <label for="fieldlenght" class="col-md-3 col-xs-12 control-label">DB Field Lenght: </label> <div class="col-md-6 col-xs-12"> <div class="input-group"> <span class="input-group-addon"><span class="fa fa-pencil"></span></span> <input class="form-control lenght'+fieldcount+'" name="fields['+fieldcount+'][lenght]" type="text"> </div><span class="help-block"> Lenght for string or char and for decimal or double like (15.8)</span> </div>  </div>   <div class="form-group"> <label class="col-md-3"></label>  <div class="col-md-1"><div class="checkbox"><label><input type="checkbox" name="fields['+fieldcount+'][nullable]" value="nullable"/>Nullable </label></div></div> <div class="col-md-1" style="width: auto;"><div class="checkbox"><label><input type="checkbox" class="foreignkey" value="1" fieldcount="'+fieldcount+'" name="fields['+fieldcount+'][foreignkey]" onclick="foreignkeyFun(this)"/>Foreign key </label></div></div> <div class="col-md-1" style="width: auto;"><div class="checkbox"><label><input type="checkbox" name="fields['+fieldcount+'][unsigned]" value="1"/>Unsigned key </label></div></div> <div class="col-md-1">  <button class="btn btn-danger btn-rounded" onclick="removeCrudField(this)" date-field-count="'+fieldcount+'" type="button"><span class="fa fa-times"></span></button> </div> </div> <div class="form-group foreignkeybox'+fieldcount+' hidden"><label class="col-md-3 col-xs-12 control-label"></label><div class="col-md-2"><input class="form-control fr_tabel_name'+fieldcount+'" placeholder="Enter tabel name" name="fields['+fieldcount+'][foreignkey_tabel]" fieldcount="'+fieldcount+'" type="text"></div><div class="col-md-2"><input class="form-control fr_field_name'+fieldcount+'" placeholder="Enter field name" name="fields['+fieldcount+'][foreignkey_field]" fieldcount="'+fieldcount+'" type="text"></div><div class="col-md-2"><select class="form-control select ondelete'+fieldcount+'" name="fields['+fieldcount+'][foreignkey_ondelete]"><option value=""> Select on delete action</option><option value="CASCADE">CASCADE</option><option value="SET NULL">SET NULL</option><option value="NO ACTION">NO ACTION</option><option value="RESTRICT">RESTRICT</option></select></div><div class="col-md-2"><select class="form-control select onupdate'+fieldcount+'" name="fields['+fieldcount+'][foreignkey_onupdate]"><option value=""> Select on update action</option><option value="CASCADE">CASCADE</option><option value="SET NULL">SET NULL</option><option value="NO ACTION">NO ACTION</option><option value="RESTRICT">RESTRICT</option></select></div></div>  </div>';

        $("#fieldgroup").append(field);
        $('.select').selectpicker('refresh');
    };

/**********************removeCrudField*****************************************/
function removeCrudField(thisfield){
    var fieldcount = parseInt($(thisfield).attr("date-field-count"));

    var checkstr =  confirm('Are you sure you want to delete this?');
    if(checkstr == true){
        $("#fieldgroup").find("#field"+fieldcount).remove();
    }else{
    return false;
    }
    
};

/**********************foreignkeyFun*****************************************/
function foreignkeyFun(thisfield)
{
  var fieldCount =$(thisfield).attr("fieldCount");
    if ($(thisfield).prop('checked')==true){ 
       $(".foreignkeybox"+fieldCount).removeClass("hidden");
       $(".ondelete"+fieldCount).attr("required", "required");
       $(".onupdate"+fieldCount).attr("required", "required");
       $(".fr_field_name"+fieldCount).attr("required", "required");
       $(".fr_tabel_name"+fieldCount).attr("required", "required");
    }
    else{
        $(".foreignkeybox"+fieldCount).addClass("hidden");
        $(".ondelete"+fieldCount).removeAttr("required");
        $(".onupdate"+fieldCount).removeAttr("required");
        $(".fr_field_name"+fieldCount).removeAttr("required");
        $(".fr_tabel_name"+fieldCount).removeAttr("required");
    }

};

/**********************labeldbname*****************************************/
function labeldbname(thisfield)
{
  var thisfield_value=$(thisfield).val();
  var fieldcount=$(thisfield).attr('fieldcount');
  var slugifyvalue =slugify(thisfield_value);
  $("#field"+fieldcount).find(".dbname"+fieldcount).val(slugifyvalue);
};
/**********************dbname*****************************************/
function dbname(thisfield)
{
  var thisfield_value=$(thisfield).val();
  var slugifyvalue =slugify(thisfield_value);
  $(thisfield).val(slugifyvalue);
};
/**********************slugify*****************************************/
function slugify(text)
{
  return text.toString().toLowerCase()
    .replace(/\s+/g, '_')           // Replace spaces with -
    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
    .replace(/\-\-+/g, '_')         // Replace multiple - with single -
    .replace(/^-+/, '')             // Trim - from start of text
    .replace(/-+$/, '');            // Trim - from end of text
};
</script>
@endsection