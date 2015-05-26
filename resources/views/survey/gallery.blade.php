@extends('layout.app')

@section('title', 'Create a new Survey')

@section('breadcrumb')
	<li>
		Survey Gallery
	</li>
@endsection

@section('content')

	<div class="page-header">
		<h1>
			Survey Gallery
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">

			    <!-- PAGE CONTENT BEGINS -->
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        Disculpe! Exíste un problema.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                            <!-- view handling messages -->
                @include('errors.error')

				{!! Form::open(array('method'=>'POST' , 'url' => url('/survey/gallery'),  'role'=>'form',  'class'=>'form-horizontal')) !!}
                <input type="hidden" id="qInput" name="qInput" value="">
                {!! Form::text('survey-id',null, array('placeholder' => 'Id encuesta','id'=>'survey-id', 'class'=>'col-xs-12 col-sm-10 name')) !!}
                <a class="verGaleria" href="#" data-rel="colorbox">Ver galeria</a>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <button class="btn btn-info get-gallery">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            Enviar
                        </button>
                    </div>
                </div>
				{!! Form::close() !!}
			<!-- PAGE CONTENT ENDS -->

		</div><!-- /.col -->
	</div><!-- /.row -->
@endsection
@section('script')
    <script type="text/javascript">
        jQuery(function($) {

            $('.get-gallery').on('click', function(e){
                e.preventDefault();

                var surveyId = $('#survey-id').val();

                $.ajax({
                    url: '{!!  url("/survey/gallery") !!}/'+surveyId,
                    type: "GET",
                    dataType: 'json',
                    data: '',
                    success: function(data) {
                    console.log(data)
                        buildGallery(data.images);
                    },
                    error:function(data) {
                        alert('Disculpe. Ocurrió un error')
                    }
                });

            });
        });
        $('a.verGaleria').on("click", function(e){
            e.preventDefault();
            $('a.survImg').first().trigger('click')
        });
        function buildGallery(images){

            var url = '{{ url("uploads/")}}/';
            var html = '<div class="surveyGallery hide">';
            html += '<ul class="ace-thumbnails clearfix surveyImgs">';
            $.each(images, function( index, value ) {

                html+='<li>' +
                 '      <div>' +
                 '          <img  value="'+value.id+'" width="150" height="150" alt="150x150" src="'+url+value.image+'" />' +
                 '          <div class="text">' +
                 '              <div class="inner">' +
                 '                  <span>'+value.name+'</span><br />' +
                 '                  <a class="survImg" href="'+url+value.image+'" data-rel="colorbox">' +
                 '                      <i class="ace-icon fa fa-search-plus"></i>' +
                 '                  </a>' +
                 '                  <a href="#" class="delete-img">' +
                 '                      <i class="ace-icon fa fa-times"></i>' +
                 '                  </a>' +
                 '              </div>' +
                 '          </div>' +
                 '      </div>' +
                 '  </li>';
            });
            html+= '</ul>';
            html+= '</div>';

            $('.page-content').append(html);
            $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
            $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>");//let's add a custom loading icon


            $(document).one('ajaxloadstart.page', function(e) {
                $('#colorbox, #cboxOverlay').remove();
            });
        }

        //colorbox section
        var $overflow = '';
        var colorbox_params = {
            rel: 'colorbox',
            reposition:true,
            scalePhotos:true,
            scrolling:false,
            previous:'<i class="ace-icon fa fa-arrow-left"></i>',
            next:'<i class="ace-icon fa fa-arrow-right"></i>',
            close:'&times;',
            current:'{current} of {total}',
            maxWidth:'100%',
            maxHeight:'100%',
            onOpen:function(){
                $overflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            },
            onClosed:function(){
                document.body.style.overflow = $overflow;
            },
            onComplete:function(){
                $.colorbox.resize();
            }
        };



    </script>
@endsection

