<?php

require_once('../../private/initialize.php');

	$args =[];
	//Post variables 
	isset($_POST['type'])
		? $type = $_POST['type']
		: $type = null;
	isset($_POST['title'])
		? $args['title'] = $_POST['title']
		: $args['title'] = null;
	if(!empty($_POST['author'])){
		$authors = [];
		foreach($_POST['author'] as $a){
			if($a != ''){
				array_push($authors, $a);
			}
		}
		$args['authors'] = $authors;
	} else{
		$args['authors'] = [];
	}
	if(!empty($_POST['presenter'])){
		$presenters = [];
		foreach($_POST['presenter'] as $p){
			if($p != ''){
				array_push($presenters, $p);
			}
		}
		$args['presenters'] = $presenters;
	} else{
		$args['presenters'] = [];
	}
	if(!empty($_POST['supervisor'])){
		$supervisors = [];
		foreach($_POST['supervisor'] as $s){
			if($s != ''){
				array_push($supervisors, $s);
			}
		}
		$args['supervisor'] = $supervisors;
	} else{
		$args['supervisor'] = [];
	}
	if(!empty($_POST['editor'])){
		$editors = [];
		foreach($_POST['editor'] as $e){
			if($e != ''){
				array_push($editors, $e);
			}
		}
		$args['editors'] = $editors;
	} else{
		$args['editors'] = [];
	}
	if(!empty($_POST['creator'])){
		$creators = [];
		foreach($_POST['creator'] as $c){
			if($c != ''){
				array_push($creators, $c);
			}
		}
		$args['creators'] = $creators;
	} else{
		$args['creators'] = [];
	}
	if(!empty($_POST['uploader'])){
		$uploaders = [];
		foreach($_POST['uploader'] as $u){
			if($u != ''){
				array_push($uploaders, $u);
			}
		}
		$args['uploaders'] = $uploaders;
	} else{
		$args['uploaders'] = [];
	}
	if(!empty($_POST['webmaster'])){
		$webmasters = [];
		foreach($_POST['webmaster'] as $w){
			if($w != ''){
				array_push($webmasters, $w);
			}
		}
		$args['webmasters'] = $webmasters;
	} else{
		$args['webmasters'] = [];
	}
	isset($_POST['year'])
		? $args['year'] = $_POST['year']
		: $args['year'] = null;
	isset($_POST['journal'])
		? $args['journal'] = $_POST['journal']
		: $args['journal'] = null;
	isset($_POST['volume'])
		? $args['volume'] = $_POST['volume']
		: $args['volume'] = null;
	isset($_POST['issue'])
		? $args['issue'] = $_POST['issue']
		: $args['issue'] = null;
	isset($_POST['date'])
		? $args['date'] = $_POST['date']
		: $args['date'] = null;
	isset($_POST['location'])
		? $args['location'] = $_POST['location']
		: $args['location'] = null;
	isset($_POST['level'])
		? $args['level'] = $_POST['level']
		: $args['level'] = null;
	isset($_POST['conference'])
		? $args['conference'] = $_POST['conference']
		: $args['conference'] = null;
	isset($_POST['website'])
		? $args['website'] = $_POST['website']
		: $args['website'] = null;
	!empty($_FILES['srcLocation'])
		? $file = $_FILES['srcLocation']
		: $file = null;
	print_r($args);
	echo "<br /> <br />";

	switch($type)
	{
		case "a":
			$article = new Article($args);
			echo Article::create_citation($article) . "<br />";
			Article::insertSource($article);
			Article::insertAuthors($article);
			if($file){
				Article::uploadFile($article, $file);
				//print_r(var_dump($article));
				//echo "<br />";
			}
			break;
		case "b":
			$book = new Book($args);
			echo Book::create_citation($book) . "<br />";
			Book::insertBook($book);
			Book::insertAuthors($book);
			Book::insertEditors($book);
			if($file){
				Book::uploadFile($book, $file);
				//print_r(var_dump($book));
				//echo "<br />";
			}
			break;
        case "po":
            $poster = new Poster($args);
            echo Poster::create_citation($poster) . "<br />";
            Poster::insertSource($poster);
            Poster::insertPresenters($poster);
            if($file){
                Poster::uploadFile($poster, $file);
                //print_r(var_dump($presentation));
                //echo "<br />";
            }
            break;
        case "pr":
			$presentation = new Presentation($args);
			echo Presentation::create_citation($presentation) . "<br />";
			Presentation::insertSource($presentation);
			Presentation::insertPresenters($presentation);
			if($file){
				Presentation::uploadFile($presentation, $file);
				//print_r(var_dump($presentation));
				//echo "<br />";
			}
            break;
        case "r":
            $radio = new Radio($args);
            echo Radio::create_citation($radio) . "<br />";
            Radio::insertSource($radio);
            Radio::insertPresenters($radio);
            if($file){
                Radio::uploadFile($radio, $file);
                //print_r(var_dump($presentation));
                //echo "<br />";
            }
            break;
		default:
	}
	
	
?>