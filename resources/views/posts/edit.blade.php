@extends('app')

@section('title')
Edit Post
@endsection

@section('content')
<script type="text/javascript" src="{{ asset('/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery.min-2.1.3.js')}}"></script>
<script type="text/javascript">
var found_images=[];
	function insert_image() 
	{ 
		if (found_images.length!=0){
			var image_tag="<img src='"+found_images[found_images.length-1]+"'>"; 
			var doctarget = CKEDITOR.instances.editor1; 
			doctarget.insertHtml(image_tag); 
			found_images.pop();}
	}

    function AjaxFormRequest(result_id,form_id,url) 
    {
        jQuery.ajax({
            url: url,
            type:'POST',
            data:jQuery("#"+form_id).serialize(),
            success: function(response) { 
            		found_images.push(response);
                    $('<img src='+response+'>').appendTo("#result_div_id");
                }, 
            error: function(response) {  
                document.getElementById(result_id).innerHTML = "error"; 
                }               
        });
    };

</script>

<form method="post" action='{{ url("/update") }}' id="article">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="post_id" value="{{ $post->id }}{{ old('post_id') }}">
	<div class="form-group">
		<input required="required" placeholder="Enter title here" type="text" name = "title" class="form-control" value="@if(!old('title')){{$post->title}}@endif{{ old('title') }}"/>
	</div>

	<div id="result_div_id" style="width:100%;height=180px;background-color: #DCDCDC;"></div>

	<div class="form-group">
		<textarea name="body" class="form-control" id="editor1">
			@if(!old('body'))
			{!! $post->body !!}
			@endif
			{!! old('body') !!}
		</textarea>
		<script type="text/javascript">
			var editor = CKEDITOR.replace( 'editor1' );
		</script>
	</div>
	<div class="form-group" style="float:left;">
	@if($post->active == '1')
	<input type="submit" name='publish' class="btn btn-success" value = "Update"/>
	@else
	<input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
	@endif
	<input type="submit" name='save' class="btn btn-default" value = "Save As Draft" />
	<a href="{{  url('delete/'.$post->id.'?_token='.csrf_token()) }}" class="btn btn-danger">Delete</a>
	</div>
</form>
<div style="float:right;">
	<input type="submit" class="btn btn-success" value = "search image" onclick="AjaxFormRequest('result_div_id','article', '{{asset('ajax_respons.php')}}')"/>
	<input type="submit" name='insert_img'class="btn btn-success" value = "insert image" onclick="insert_image()"/>
</div>
@endsection
