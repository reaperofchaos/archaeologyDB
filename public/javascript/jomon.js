/*
var click = 0;
function showMenu(){
	var displayed = document.getElementById('mainmenu').style.display;
	if (displayed == "none"){
	document.getElementById("mainmenu").style.display="block";
	}else{
	document.getElementById("mainmenu").style.display = "none";
	};
}

function showSearchMenu(){
	var displayed = document.getElementById('articleSearch').style.display;
	console.log(displayed);
	if (displayed == "none"){
	document.getElementById("articleSearch").style.display="block";
	}else{
	document.getElementById("articleSearch").style.display = "none";
	};
}
$(document).ready(function(){
  $("#searchArticles").click(function(){
    $("#content").load('article_search.php');
  });
  $("#searchArtifacts").click(function(){
    $("#content").load('artifact_search.php');
  });
  $("#searchRadiocarbonDates").click(function(){
    $("#content").load('radiocarbon_search.php');
  });
   $("#searchSites").click(function(){
    $("#content").load('site_search.php');
  });
   $("#jomonSiteMap").click(function(){
    $("#content").load('jomonmap.html');
  });
   $("#workArticles").click(function(){
    $("#content").load('work_Articles.php');
  });
});
*/

function selectFormType(id){
	var formName = '';
	var s = document.getElementById('srcType_'+id);
	var sourceType = s.options[s.selectedIndex].value;
	switch(sourceType){
		case 'a':
		   formName = "articleForm";
		   break;
		case 'ab':
		   formName = "abstractForm";
		   break;
		case 'b':
			formName = "bookForm";
		   break;
		case 'd':
		    formName = "dissertationForm";
		    break;
		case 'po':
		    formName = "posterForm";
		    break;
		case 'pr':
		    formName = "presentationForm";
		    break;
		case 'r':
			formName = "radioPresentationForm";
			break;
		case 't':
			formName = "thesisForm";
			break;
		case 'v':
			formName = "videoForm";
			break;
		case 'w':
			formName = "websiteForm";
			break;
		default:
			break;
	}
	var location = 'sourceForm_'+id;
	formName 
		? NewForm.buildFormDiv(formName, location, id)
		: document.getElementById(location).innerHTML = "";
}