<div class="from-group widget-box col-xs-12 col-sm-10">
    <div class="widget-header">
        <h5 class="widget-title">Datos de la encuesta</h5>
    </div>
    <div class="">
        <div class="widget-main">
            <div class="form-group col-xs-12 col-sm-12">
                {!! Form::text('name',null, array('placeholder' => 'Nombre de la encuesta','id'=>'survey-name', 'class'=>'col-xs-12 col-sm-10 name')) !!}
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                {!! Form::select('unit_id', $units, null, array('class' => 'col-xs-12 col-sm-6 unit')) !!}
            </div>
        </div>
    </div>
</div>
<!-- Question Builder-->
<div class="widget-box col-xs-12 col-sm-10">
    <div class="widget-header">
        <h5 class="widget-title">Constructor de preguntas</h5>
    </div>
    <div class="">
        <div class="widget-main">
            <div class="row show-grid">
                <div class="col-xs-12 col-sm-3">
                    <button data-toggle="dropdown" class="btn btn-primary btn-white dropdown-toggle btn-type" aria-expanded="true">
                        <span>Tipo de Pregunta</span>
                        <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                    </button>

                    <ul class="dropdown-menu question-type">
                        <li>
                            <a href="#" data-type="1"><i class="ace-icon glyphicon glyphicon-text-width"></i> Texto</a>
                        </li>

                        <li>
                            <a href="#" data-type="2"><i class="ace-icon fa fa-check-square-o"></i> Selección múltiple</a>
                        </li>

                        <li>
                            <a href="#" data-type="3"><i class="ace-icon fa fa-circle-o"></i> Selección simple</a>
                        </li>
                        <li>
                            <a href="#" data-type="4"><i class="ace-icon glyphicon glyphicon-align-justify"></i> Lista</a>
                        </li>
                        <li>
                            <a href="#" data-type="5"><i class="ace-icon fa fa-calendar"></i> Fecha</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <label class="col-xs-10 col-sm-10 no-padding-left" for="question-name">Pregunta</label>
                    {!! Form::text('question-name', '', array('id'=>'question-name','placeholder' => 'Ingresa la pregunta', 'class'=>'col-xs-10 col-sm-10')) !!}
                </div>
            </div>

            <div class="row show-grid option-form ">
                <div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-offset-3">
                    <label class="col-xs-10 col-sm-10 no-padding-left" for="question-name">Opciones</label>
                    {!! Form::text('option-input', '', array('id'=>'option-input', 'placeholder' => 'ingresa la opción', 'class'=>'col-xs-9 col-sm-9')) !!}
                    <button class="add-option btn btn-success btn-sm col-xs-1 col-sm-1">
                        <i class="ace-icon fa fa-plus icon-only"></i>
                    </button>
                </div>
            </div>
            <div class="row show-grid">
                <div class="options-ctn col-xs-12 col-sm-9 col-sm-offset-3 col-md-offset-3">
                </div>
            </div>
        </div>
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <button class="add-question btn btn-success">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!--  Questions shown to users  -->
<div class="widget-box col-xs-12 col-sm-10 widget-result">
    <div class="widget-header">
        <h5 class="widget-title">Encuesta resultante</h5>
    </div>
    <div class="">
        <div class="widget-main">
        </div>
    </div>
</div>
<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">
        <button class="btn btn-info create-survey">
            <i class="ace-icon fa fa-check bigger-110"></i>
            {{ $submitButtonText }}
        </button>

        &nbsp; &nbsp; &nbsp;
        <button class="btn" type="reset">
            <i class="ace-icon fa fa-undo bigger-110"></i>
            Borrar
        </button>
    </div>
</div>