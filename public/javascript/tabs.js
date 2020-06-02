  $(document).ready(function(){
		createAuthorList();
		createSiteList();
		//createSourceList();
		//create popup
		  $(document.body).on('click', '.popup', function(){
	      $(this).draggable().resizable();
		  })
		     $(document.body).on('click', '.radioCarbon', function(){
				var id = this.id
				src_id = id.split('_');
				src_id = src_id[0];
				var src_type = src_id.slice(0,1)
				var src_article_id = src_id.slice(2, ); 				src_id = src_type +"-"+ src_article_id
				var name = id+"_popup"
				var display_name = "Radiocarbon Dates"
				console.log(src_id);
				try{
				$.post("../private/shared/radiocarbonDatesTotal.php",
					  {
					  src_id: src_id
					  },
					  function(data, status){
						buildPopup(name, display_name, data);
					  });
				} catch(err){
				  console.log("Unable to do ajax for radiocarbonDatesTotal.php");
				  console.log(err.message);
				}
				});
				$(document.body).on('click', '.addSource', function(){
					var id =nextTab('mainMenu');
					var name = "Source_Popup"
					var display_name = "Add Source"
					try{
					$.post("../private/shared/addArticle.php",
							{
							id: id
							},
							function(data, status){
							createTab(name, display_name, data, "main");
							});
					} catch(err){
						console.log("Unable to do ajax for addArticle.php");
						console.log(err.message);
					}
					}); 
				 $(document.body).on('click', '.stableIsotopes', function(){
				var id = this.id
				src_id = id.split('_');
				src_id = src_id[0];
				var src_type = src_id.slice(0,1)
				var src_article_id = src_id.slice(2, ); 
				src_id = src_type +"-"+ src_article_id
				var name = id+"_popup"
				var display_name = "Stable Isotopes"
				console.log(src_id);
				try{
				$.post("./../private/shared/stableIsotopesTotal.php",
					  {
					  src_id: src_id
					  },
					  function(data, status){
						buildPopup(name, display_name, data);
					  });
				} catch(err){
				  console.log("Unable to do ajax for getStableIsotopes.php");
				  console.log(err.message);
				}
				}); 
				$(document.body).on('click', '.plantRemains', function(){
				var id = this.id
				src_id = id.split('_');
				src_id = src_id[0];
				var src_type = src_id.slice(0,1)
				var src_article_id = src_id.slice(2, ); 
				src_id = src_type +"-"+ src_article_id
				var name = id+"_popup"
				var display_name = "Plant Remains"
				console.log(src_id);
				try{
				$.post("../private/shared/plantTotals.php",
					  {
					  src_id: src_id
					  },
					  function(data, status){
						buildPopup(name, display_name, data);
					  });
				} catch(err){
				  console.log("Unable to do ajax for plantTotals.php");
				  console.log(err.message);
				}
				}); 
				$(document.body).on('click', '.artifacts', function(){
				var id = this.id
				src_id = id.split('_');
				src_id = src_id[0];
				var src_type = src_id.slice(0,1)
				var src_article_id = src_id.slice(2, ); 
				src_id = src_type +"-"+ src_article_id
				var name = id+"_popup"
				var display_name = "Artifacts"
				console.log(src_id);
				try{
				$.post("../private/shared/artifactTotals.php",
					  {
					  src_id: src_id
					  },
					  function(data, status){
						buildPopup(name, display_name, data);
					  });
				} catch(err){
				  console.log("Unable to do ajax for artifactTotals.php");
				  console.log(err.message);
				}
				}); 
				$(document.body).on('click', '.sites', function(){
				var id = this.id
				src_id = id.split('_');
				src_id = src_id[0];
				var src_type = src_id.slice(0,1)
				var src_article_id = src_id.slice(2, ); 
				src_id = src_type +"-"+ src_article_id
				var name = id+"_popup"
				var display_name = "Jomon Sites"
				console.log(src_id);
				try{
				$.post("./getSites.php",
					  {
					  src_id: src_id
					  },
					  function(data, status){
						buildPopup(name, display_name, data);
					  });
				} catch(err){
				  console.log("Unable to do ajax for getSites.php");
				  console.log(err.message);
				}
				});
				$(document.body).on('click', '.tags', function(){
				var id = this.id
				src_id = id.split('_');
				src_id = src_id[0];
				var src_type = src_id.slice(0,1)
				var src_article_id = src_id.slice(1, ); 
				src_id = src_type +"-"+ src_article_id
				var name = id+"_popup"
				var display_name = "Tags"
				console.log(src_id);
				try{
				$.post("./getTags.php",
					  {
					  src_id: src_id
					  },
					  function(data, status){
						buildPopup(name, display_name, data);
					  });
				} catch(err){
				  console.log("Unable to do ajax for getTags.php");
				  console.log(err.message);
				}
				});
			//bibliography
			$(document.body).on('click', '.bibliography', function(){
				var id = this.id
				src_id = id.split('_');
				src_id = src_id[0];
				var src_type = src_id.slice(0,1)
				var srcID = src_id.slice(2, ); 
				src_id = src_type +"-"+ srcID;
				var name = id+"_popup"
				var display_name = "Bibliography"
				console.log(src_id);
				try{
				$.post("../private/shared/bibliography.php",
					  {
					  src_id: src_id
					  },
					  function(data, status){
						buildPopup(name, display_name, data);
					  });
				} catch(err){
				  console.log("Unable to do ajax for getTags.php");
				  console.log(err.message);
				}
				});
				//change log
				$(document.body).on('click', '.changeLog', function(){
					var id = this.id
					src_id = id.split('_');
					src_id = src_id[0];
					var src_type = src_id.slice(0,1)
					var src_article_id = src_id.slice(2, ); 
					src_id = src_type +"-"+ src_article_id
					var name = id+"_popup"
					var display_name = "Change Log"
					console.log(src_id);
					try{
					$.post("../private/shared/changeLog.php",
						{
						  src_id: src_id
						  },
						  function(data, status){
							buildPopup(name, display_name, data);
						  });
					} catch(err){
					  console.log("Unable to do ajax for getTags.php");
					  console.log(err.message);
					}
					});
			//login modal
			$(document.body).on('click', '#loginSubmit', function(e){
				e.preventDefault();	
				var results = document.getElementById('loginResults');
				console.log($('#loginForm').serialize());
				try{
					$.post("../public/login.php",
						   $('#loginForm').serialize())
						   .done(function(data, status){
								$('#login').modal('hide');
								updateLoginButtons(true);
						   });	
				} catch(err){
				  console.log("Unable to do ajax for login.php");
				  console.log(err.message);
				}
				});
				$(document.body).on('click', '#registerSubmit', function(e){
					e.preventDefault();	
					try{
						$.post("../public/register.php",
							   $('#registerForm').serialize())
							   .done(function(data, status){
									$('#register').modal('hide');
									$('#login').modal('show');
									updateLoginButtons(false);
							   });	
					} catch(err){
					  console.log("Unable to do ajax for register.php");
					  console.log(err.message);
					}
					});
				//logout modal
			$(document.body).on('click', '#logoutSubmit', function(e){
				e.preventDefault();	
				try{
					$.post("../public/logout.php",
						   $('#logoutForm').serialize())
						   .done(function(data, status){
								$('#logout').modal('hide');
								updateLoginButtons(false);
						   });	
				} catch(err){
				  console.log("Unable to do ajax for logout.php");
				  console.log(err.message);
				}
				});		
			//create close button in popup
			$(document.body).on('click', '.closePopup', function(){
			  var id  = this.id;
				id = id.replace("_Button", "");
				console.log(id);
				var element = document.getElementById(id);
				element.parentNode.removeChild(element);
				console.log(id + " was removed");
			})
			 //Build select boxes
			  $(document.body).on('click', '.tag' ,function(){
							//get id of tag that was clicked
							var idTag = $(this).attr('id');
							console.log(idTag);
							var idReg = /.*\_.*\_(\d)/m;
							var recordReg = /([A-Z]\d.*)\_[A-Za-z].*\_\d.*/m;
							//A73tag_1
							ids = idReg.exec(idTag);
							var recordNos = recordReg.exec(idTag);
							console.log(recordNos);
							var recordNo = recordNos[1];
							tagNo = ids[1];
							console.log(tagNo);
							//get the value of the dropdown
							var tagValue = $(this).find(":selected").text();
							console.log(tagValue);
							//get the id of the parent div tag for the select box
							var levelDiv = $(this).closest('div').prop('id');
							var levelReg = /[A-Z]\d.*[l](\d).*\_\d/m;
							var levels = levelReg.exec(levelDiv);
							var level = levels[1];
							console.log(level);
							//Create and append the select box to the appropriate div
							createTagsFields(tagValue, level, tagNo, recordNo);
				  })
			  $('.nav-tabs').on('click', 'a', function(e){
				  e.preventDefault();
				  $(this).tab('show');
			  })
			   .on('click', 'span', function () {
				var anchor = $(this).siblings('a');
				$(anchor.attr('href')).remove();
				$(this).parent().remove();
				$('.nav-tabs li').children('a').first().click();
			})
			
			$(document.body).on('click', '#getAuthors' ,function(){
				var tabName = "authorList";
				var displayName = 'Authors';
				var location = "main";
				var ID = 1; 
				$.get("./includes/authorlist.php",
					  {
						authorPage: ID
					  },
					  function(data, status){
						createTab2(tabName, displayName, data, location);
					  });
				});
				$(document.body).on('click', '#getSkeletons' ,function(){
					var tabName = "skeletonList";
					var displayName = 'Skeletons';
					var location = "main";
					var ID = 1; 
					$.get("./includes/skeletonList.php",
						  {
							skeletonPage: ID
						  },
						  function(data, status){
							createTab2(tabName, displayName, data, location);
						  });
					});
					$(document.body).on('click', '#getFauna' ,function(){
						var tabName = "faunaList";
						var displayName = 'Fauna';
						var location = "main";
						var ID = 1; 
						$.get("./includes/faunaList.php",
							  {
								faunaPage: ID
							  },
							  function(data, status){
								createTab2(tabName, displayName, data, location);
							  });
						});
						$(document.body).on('click', '#getPlants' ,function(){
							var tabName = "plantList";
							var displayName = 'Plants';
							var location = "main";
							var ID = 1; 
							$.get("./includes/plantList.php",
								  {
									plantPage: ID
								  },
								  function(data, status){
									createTab2(tabName, displayName, data, location);
								  });
							});
				$(document.body).on('click', '#getSources' ,function(){
					var tabName = "sourceList";
					var displayName = 'Sources';
					var location = "main";
					var ID = 1; 
					$.get("./includes/recordList.php",
						  {
							page: ID
						  },
						  function(data, status){
							createTab2(tabName, displayName, data, location);
						  });
					});
					$(document.body).on('click', '#getSiteList' ,function(){
						var tabName = "siteList";
						var displayName = 'Sites';
						var location = "main";
						var ID = 1; 
						$.get("./includes/siteList.php",
							  {
								sitePage: ID
							  },
							  function(data, status){
								createTab2(tabName, displayName, data, location);
							  });
						});
						$(document.body).on('click', '#getDogu' ,function(){
							//console.log('clicked')
							var tabName = "dogu";
							var displayName = 'Dogu';
							var location = "main";
							var ID = 1; 
							$.get("./includes/dogu/index.php",
								  {
									page: ID
								  },
								  function(data, status){
									createTab(tabName, displayName, data, location);
								  });
							});
			$(document.body).on('click', '.record' ,function(){
				var ID = this.value;
				console.log(ID);
				var src = ID.split('_');
				s = src[0];
				var src_type = s.slice(0,1)
				var src_id = s.slice(2, );
				$.post("./getRecord.php?r=1",
					  {
					  ID: ID
					  },
					  function(data, status){
						createTab(ID, ID, data, "main");
						//load notes
						var notes = document.getElementById('notes_'+src_id);
						$.post("../private/shared/notesInSource.php",
								{
								src_id: ID
								},
								function(d, status){
									notes.innerHTML = d;
								});
						//load radiocarbon
						var radiocarbon = document.getElementById('radiocarbon_'+src_id);
						$.post("../private/shared/radioCarbonDatesInSource.php",
								{
								src_id: ID
								},
								function(d, status){
									radiocarbon.innerHTML = d;
								});
						//load stable isotopes
						var stable_isotopes = document.getElementById('stableIsotopes_'+src_id);
						$.post("../private/shared/stableIsotopesInSource.php",
								{
								src_id: ID
								},
								function(d, status){
									stable_isotopes.innerHTML = d;
								});
						//load plant remains
						var plant_remains = document.getElementById('plantRemains_'+src_id);
						$.post("../private/shared/plantsInSource.php",
								{
								src_id: ID
								},
								function(d, status){
									plant_remains.innerHTML = d;
								});
						//load artifacts
						var artifacts = document.getElementById('artifacts_'+src_id);
						$.post("../private/shared/artifactInSource.php",
								{
								src_id: ID
								},
								function(d, status){
									artifacts.innerHTML = d;
								});
						//load sites
						var sites = document.getElementById('sites_'+src_id);
						$.post("../private/shared/sitesInSource.php",
								{
								src_id: ID
								},
								function(d, status){
									sites.innerHTML = d;
								});
						//load sites
						var tags = document.getElementById('tags_'+src_id);
						$.post("../private/shared/tagsInSource.php",
								{
								src_id: ID
								},
								function(d, status){
									tags.innerHTML = d;
								});
						//load bibliography
						var bibliography = document.getElementById('bibliography_'+src_id);
						$.post("../private/shared/bibliography.php",
								{
								src_id: ID
								},
								function(d, status){
								 	bibliography.innerHTML = d;
								});
						//load ChangeLog
						var changeLog = document.getElementById('changeLog_'+src_id);
						$.post("../private/shared/changeLog.php",
								{
								src_id: ID
								},
								function(d, status){
									changeLog.innerHTML = d;
								});
					  });
				}); 
				$(document.body).on('click', '.authorRecord' ,function(){
					var label = this.value;
					var ID = label.split(" ").join(""); 
					var tabName = ID.split(".").join("");	
					$.post("./getAuthor.php",
						  {
						  ID: ID
						  },
						  function(data, status){
							createTab(tabName, label, data, "main");
							//listener on new records
							$(document.body).on('click', '.record' ,function(){
								var ID = this.value;
								console.log(ID);
								$.post("./getRecord.php?r=1",
									  {
									  ID: ID
									  },
									  function(data, status){
										createTab(ID, ID, data, "main");
							
									  });
									})
								})
				})
								$(document.body).on('click', '.siteRecord' ,function(){
									var siteName = this.value;
									var tabName = siteName.split(" ").join(""); 
									$.post("./getSite.php",
										  {
											siteName: siteName
										  },
										  function(data, status){
											createTab(tabName, siteName, data, "main");
											//listener on new records
											$(document.body).on('click', '.record' ,function(){
												var ID = this.value;
												console.log(ID);
												$.post("./getRecord.php?r=1",
													  {
													  ID: ID
													  },
													  function(data, status){
														createTab(ID, ID, data, "main");
													  });
												});
						  });
					});
					$(".searchButton").click(function(){
						var type = this.name;
						var authorSearch = document.getElementById('author_search');
						if(authorSearch.value)
						{
							var author = authorSearch.value;
						}
						else 
						{
							var author = ''; 
						}
						var siteName = document.getElementById('site_name');
						if(siteName.value)
						{
							var site = siteName.value;
						}
						else 
						{
							var site = ''; 
						}
						var source = document.getElementById('source_title');
						 if(source.value)
						 {
							var sourceID = source.value;
						  }
						  else {
							  var sourceID = ''; 
						  }
						console.log(`search term is ${sourceID}`)
						console.log(`search term is ${site}`)
						console.log(`search term is ${author}`)
						var ID;
						var tabName; 
						console.log(`Current type is ${type}`)
						switch(type)
						{
							case "searchSource":
								$.post("./getRecord.php?r=1",
									{
										ID: sourceID
									},
									function(data, status){
										createTab(sourceID, sourceID, data, "main");
										var src = sourceID.split('_');
										s = src[0];
										var src_type = s.slice(0,1)
										var src_id = s.slice(2, );	
												//load notes
												var notes = document.getElementById('notes_'+src_id);
												$.post("../private/shared/notesInSource.php",
														{
														src_id: sourceID
														},
														function(d, status){
															notes.innerHTML = d;
														});
												//load radiocarbon
												var radiocarbon = document.getElementById('radiocarbon_'+src_id);
												$.post("../private/shared/radioCarbonDatesInSource.php",
														{
														src_id: sourceID
														},
														function(d, status){
															radiocarbon.innerHTML = d;
														});
												//load stable isotopes
												var stable_isotopes = document.getElementById('stableIsotopes_'+src_id);
												$.post("../private/shared/stableIsotopesInSource.php",
														{
														src_id: sourceID
														},
														function(d, status){
															stable_isotopes.innerHTML = d;
														});
												//load plant remains
												var plant_remains = document.getElementById('plantRemains_'+src_id);
												$.post("../private/shared/plantsInSource.php",
														{
														src_id: sourceID
														},
														function(d, status){
															plant_remains.innerHTML = d;
														});
												//load artifacts
												var artifacts = document.getElementById('artifacts_'+src_id);
												$.post("../private/shared/artifactInSource.php",
														{
														src_id: sourceID
														},
														function(d, status){
															artifacts.innerHTML = d;
														});
												//load sites
												var sites = document.getElementById('sites_'+src_id);
												$.post("../private/shared/sitesInSource.php",
														{
														src_id: sourceID
														},
														function(d, status){
															sites.innerHTML = d;
														});
												//load sites
												var tags = document.getElementById('tags_'+src_id);
												$.post("../private/shared/tagsInSource.php",
														{
														src_id: sourceID
														},
														function(d, status){
															tags.innerHTML = d;
														});
												//load bibliography
												var bibliography = document.getElementById('bibliography_'+src_id);
												$.post("../private/shared/bibliography.php",
														{
														src_id: sourceID
														},
														function(d, status){
															bibliography.innerHTML = d;
														});
												//load ChangeLog
												var changeLog = document.getElementById('changeLog_'+src_id);
												$.post("../private/shared/changeLog.php",
														{
														src_id: sourceID
														},
														function(d, status){
															changeLog.innerHTML = d;
												});
										});
							break;
							case "searchAuthor":
								ID = author.split(" ").join(""); 
								tabName = ID.split(".").join("");
								$.post("./getAuthor.php",
								{
									ID: ID
								},
								function(data, status){
									createTab(tabName, author, data, "main");
								});
							break;
							case "searchSite":
								s = site.split(" ").join(""); 
								tabName = s.split(".").join("");
								$.post("./getSite.php?r=1",
									{
										siteName: site
									},
									function(data, status){
										createTab(tabName, site, data, "main");
									}
								);
							break;
							default:

						}
						
					});
					
					$(".pagination").click(function(){
						var page = this.id; 

						console.log(`current page ${page}`)
						$.get("../includes/authorlist.php",
							  {
							  authorPage: page
							  },
							  function(data, status){
								$('.authorList').html(data);
								$('.nav-tabs a[href="#author"]').tab('show');
							  });
						}); 
	});
	
	
	const nextTab = (div) =>
		{
			var tabs = document.getElementById(div);
			var tabTotal = tabs.getElementsByTagName("li").length;
			return tabTotal + 1; 
		}
		  function createTab(tabName, displayName, value='', locations){
				var myDivMenu = locations+"Menu";
				var liId = tabName + "Nav"
				console.log(`liID is ${liId}`);
				var menuItems = document.getElementById(myDivMenu).getElementsByTagName("li");
				var exists = false;
				for (var i = 0; i < menuItems.length; i++) {
					if(menuItems[i].id == liId)
					{	
						exists = true;
						break;
					}
				}
			if(!document.getElementById(tabName) && !exists){
				$("#"+myDivMenu).append("<li class='nav-item' id='"+ liId + "'><a data-toggle='tab' class='nav-link' href='#" + tabName + "'>"+displayName+"</a><span>x</span></li>");
				$("#"+locations).append("<div class='tab-pane' id='" + tabName + "'>" + value +"</div>");
			 }
			 $("#"+myDivMenu +" a[href='#"+ tabName + "']").tab('show');
		  }
		  function createTab2(tabName, displayName, value='', locations){
			console.log(`Trying to create tab ${tabName}`);
			var myDivMenu = locations+"Menu";
			var liId = tabName + "Nav"
			console.log(`liID is ${liId}`);
			var menuItems = document.getElementById(myDivMenu).getElementsByTagName("li");
			console.log(menuItems);
			var exists = false;
				for (var i = 0; i < menuItems.length; i++) {
					if(menuItems[i].id == liId)
					{	
						exists = true;
						break;
					}
				}
			console.log(exists);
		 if(!document.getElementById(tabName) && !exists){
			$("#"+myDivMenu).append("<li class='nav-item' id='"+tabName+"Nav'><a data-toggle='tab' class='nav-link' href='#" + tabName + "'>"+displayName+"</a><span>x</span></li>");
			$("#"+locations).append(value);
		 }
		 //$("#"+myDivMenu +" a:last").tab('show');

		 $("#"+myDivMenu +" a[href='#"+ tabName + "']").tab('show');
	  }
		  function openWindow(html){
			newwindow=window.open(html,'article','height=400,width=600');
			if (window.focus) {newwindow.focus()}
			return false;
		  }
		  
		  function getSubTags(tagName, tagNo, recordNo){
			  //get the fieldName and subtags for the tag Name in tagLogic Array
			  console.log(tagName);
			  var i = 0;
			  var html = "";
			  while (i < tagLogic.length){
			  if (tagLogic[i].tag == tagName){
				 var b = 0;
				  while(b < tagLogic[i].selectBox.length){
					  console.log("There should be " + tagLogic[i].selectBox.length + "select Boxes.");
					var fieldName = tagLogic[i].selectBox[b].fieldName;
					console.log("the field name is " + fieldName);
					var a = 0;
					html += "<label for='" + recordNo + fieldName +"_"+tagNo + "'>" + fieldName + "</label>"
					+"<select id='"+ recordNo +"_" + fieldName +"_"+tagNo + "' class='tag' name='" + fieldName + "'>";
					while (a < tagLogic[i].selectBox[b].subTags.length){
						html += "<option name='"+tagLogic[i].selectBox[b].subTags[a]+"' id='"+tagLogic[i].selectBox[b].subTags[a]+"'>"+tagLogic[i].selectBox[b].subTags[a]+"</option>";
						a++;
					}
					html += "</select>";
					b++;
					}
				}
				i++;
			  }
			return html;
		  }
		 function createTagsFields(tagName, level, tagNo, recordNo){
				var tag = getSubTags(tagName, tagNo, recordNo);
				clearDivs(level, tagNo, recordNo);
				//add 1 to the new Level if <8
				if (level < 8){
				var newLevel = parseInt(level) + 1;
				var id = recordNo + "_l"+newLevel+"Tag_"+tagNo;
				console.log(id);
				//append tag to L2
				document.getElementById(id).innerHTML = tag;
				}else{
					console.log("8 is the max number of levels for select boxes");
				}
		  }
		  
		  function clearDivs(level, tagNo, recordNo){
			  var id = "";
			  level++; 
			  while (level <=8){
				id = recordNo + "_l"+ level+"Tag_"+tagNo;
				document.getElementById(id).innerHTML = ""; 
				level++
			  }
		  }
		  //create a floating draggable div
		  function buildPopup(name, title,  value=''){
			  
			  var divID = document.getElementById(name);
			  if(divID){
				 console.log(divID);
				 console.log("Div " + name + " already exists.");
			 }else{
		  var html = "<div id='" + name + "' class='popup' style=' position: absolute; z-index = 9; width: 600px; max-width:1000px; height: 400px;  max-height: 600px; border: 3px solid #000000; background-color: lightblue; position: absolute'>"
						+"<input type='button' id='" + name + "_Button' value='x' 	class='closePopup'  style='float: right;'></input>"
						+"<h3 style='padding: 20px; text-align: center;'>"+title + "</h3>"
						+"<div id='popupContent' style='background-color: white; padding: 20px; height: 300px; overflow: scroll;'>"
						+ value
						+"</div>"
					+"</div>";
		  $('#popuplist').append(html);
			 }
		  }
		//toggles Searchbox options
		function changeSearch(type){
		switch (type){
			case 'title':
				document.getElementById('searchArticles').style.display='block';
				document.getElementById('searchAuthors').style.display='none';
				document.getElementById('searchSites').style.display='none';
			break;
			case 'author':
				document.getElementById('searchArticles').style.display='none';
				document.getElementById('searchAuthors').style.display='block';
				document.getElementById('searchSites').style.display='none';
			break;
			case 'site':
				document.getElementById('searchArticles').style.display='none';
				document.getElementById('searchAuthors').style.display='none';
				document.getElementById('searchSites').style.display='block';
			break;
			default:
				document.getElementById('searchArticles').style.display='block';
				document.getElementById('searchAuthors').style.display='none';
				document.getElementById('searchSites').style.display='none';
			}
		}
		function postDatas(path, formId)
		{
			var form = document.getElementById(formId);
			result = document.getElementById(formId+"_Result");
			const Http = new XMLHttpRequest();
			var kvpairs = [];
			Http.open("POST", path);
			Http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			for ( var i = 0; i < form.elements.length; i++ ) {
				var e = form.elements[i];
				kvpairs.push(encodeURIComponent(e.name) + "=" + encodeURIComponent(e.value));
			 }
			 var queryString = kvpairs.join("&");
			console.log(queryString);
			Http.send(queryString);

			Http.onreadystatechange = (e) => {
				result.innerHTML = Http.responseText;
			}
		}

		function updateJSON(path)
		{
			var path = '../public/updateSearch.php';
			document.getElementById('refresh').style.animationPlayState="running"; 
			result = document.getElementById("updateResultsJSON");
			
			const Http = new XMLHttpRequest();
			var kvpairs = [];
			Http.open("POST", path);
			Http.send();
			var html = '';  
			var errors = 0; 
			Http.onreadystatechange = (e) => {
			  console.log(Http.status);
			  if(!Http.status == 200)
			  {
				errors++; 
				html += `<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<strong>Unable to update Sources List</strong>     
				</div>`;
			  }
			  
			  result.innerHTML = html;
			  document.getElementById('refresh').style.animationPlayState="paused";
			}
			html += `<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
						<strong>Finished Updating</strong>     
						</div>`;	
			result.innerHTML += html;
		}
		function updateLoginButtons(loggedIn)
		{
			var loginButtons = document.getElementById('loginButtons');
			var html = ''; 
			if(loggedIn)
			{
				
				html += `<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#logout'>Logout</button>`; 
			}
			else
			{
				html += `<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#login'>Login</button>
						<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#register'>Register</button>`;
			}
			loginButtons.innerHTML = html; 
		}