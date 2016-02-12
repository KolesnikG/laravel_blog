<?php 
include 'simple_html_dom.php';

if (isset($_POST["title"])) 
{
$title=$_POST["title"];
$html = file_get_html('https://pixabay.com/ru/photos/?image_type=&cat=&min_width=&min_height=&q='.$title.'&order=popular');	
foreach($html->find('img') as $element) 
{
	if(!strripos($element->src,".gif"))
		$some_img[]=$element->src;
}

echo 'https://pixabay.com'.$some_img[rand(0,count($some_img))];

}
?>