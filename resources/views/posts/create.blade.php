@extends('app')

@section('title')
Add New Post
@endsection

@section('content')

<script type="text/javascript" src="{{ asset('/js/ckeditor/ckeditor.js')  }}"></script>
<script type="text/javascript" src="jquery.min-2.1.3.js"></script>
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

<form action="/new-post" method="post" id="article">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="form-group">
		<input required="required" value="{{ old('title') }}" placeholder="Enter title here" type="text" name ="title" class="form-control" />
	</div>

	<div id="result_div_id" style="width:100%;height=180px;background-color: #DCDCDC;"></div>

	<div class="form-group">
		<textarea name="body" id="editor1" class="form-control">{{ old('body') }}</textarea>
		<script type="text/javascript">
			var editor = CKEDITOR.replace('editor1'); 
		</script>
	</div>
	<div style="float:left">
	<input type="submit" name='publish' class="btn btn-success" value = "Publish"/>
	<input type="submit" name='save' class="btn btn-default" value = "Save Draft" />
	</div>
</form>
	<div style="float:right">
	<input type="submit" name='search_img'class="btn btn-success" value = "search image" onclick="AjaxFormRequest('result_div_id','article', 'ajax_respons.php')"/>
	<input type="submit" name='insert_img'class="btn btn-success" value = "insert image" onclick="insert_image()"/>
	</div>
@endsection	