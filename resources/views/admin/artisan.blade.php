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
                            {!! Form::select('command', ['crudcommand' => 'Crud command', 'controller' => 'Controller generator command', 'model' => 'Model generator command', 'migration' => 'Migration generator command', 'view' => 'View generator command'], null, ['class' => 'form-control select', 'required' => 'required']) !!}
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
                        <div class="fieldgroup" id="fieldgroup"> 
                            <div class="field" id="field1" style="margin-bottom: 10px;"> 
                            <span class="btn btn-danger btn-rounded curdfieldcount" style="top: -5px;">1 </span>
                                <div class="form-group">
                                    {!! Form::label('fieldName', 'Field Name: ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                                    <div class="col-md-6 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            {!! Form::text('fields[1][name]', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group fieldType">
                                     {!! Form::label('fieldType', 'Select a field type : ', ['class' => 'col-md-3 col-xs-12 control-label']) !!}
                                    <div class="col-md-6">    
                                        {!! Form::select('fields[1][type]', ['string' => 'string','text' => 'text','integer' => 'integer','bigint' => 'bigint','tinyint' => 'tinyint','double' => 'double','float' => 'float','password' => 'password','email' => 'email','date' => 'date','datetime' => 'datetime','time' => 'time','timestamp' => 'timestamp','mediumtext' => 'mediumtext','longtext' => 'longtext','json' => 'json','jsonb' => 'jsonb','binary' => 'binary','number' => 'number','mediumint' => 'mediumint','smallint' => 'smallint','boolean' => 'boolean','decimal' => 'decimal'], null, ['class' => 'form-control select', 'data-live-search' => 'true']) !!}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-10">    
                                <button class="btn btn-info btn-rounded pull-right" onclick="addCrudField(this)" date-field-count="1" type="button">Add field</button>
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

        var field='<div class="field" id="field'+fieldcount+'" style="padding: 10px 0px; border-top: 1px dashed rgb(204, 204, 204);"><span class="btn btn-danger btn-rounded curdfieldcount" type="button">'+fieldcount+'</span> <div class="form-group"> <label for="fieldName" class="col-md-3 col-xs-12 control-label">Field Name: </label> <div class="col-md-6 col-xs-12"> <div class="input-group"> <span class="input-group-addon"><span class="fa fa-pencil"></span></span> <input class="form-control" required="required" name="fields['+fieldcount+'][name]" type="text"> </div> </div>  </div> <div class="form-group fieldType">  <label for="fieldType" class="col-md-3 col-xs-12 control-label">Select a field type : </label> <div class="col-md-6"> <select class="form-control select" data-live-search="true" name="fields['+fieldcount+'][type]"><option value="string">string</option><option value="text">text</option><option value="integer">integer</option><option value="bigint">bigint</option><option value="tinyint">tinyint</option><option value="double">double</option><option value="float">float</option><option value="password">password</option><option value="email">email</option><option value="date">date</option><option value="datetime">datetime</option><option value="time">time</option><option value="timestamp">timestamp</option><option value="mediumtext">mediumtext</option><option value="longtext">longtext</option><option value="json">json</option><option value="jsonb">jsonb</option><option value="binary">binary</option><option value="number">number</option><option value="mediumint">mediumint</option><option value="smallint">smallint</option><option value="boolean">boolean</option><option value="decimal">decimal</option></select> </div> <div class="col-md-1">  <button class="btn btn-danger btn-rounded" onclick="removeCrudField(this)" date-field-count="'+fieldcount+'" type="button"><span class="fa fa-times"></span></button> </div></div></div>';
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
</script>
@endsection