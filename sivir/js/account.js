var user_id;
var search_params = {};

function openTab(tabId){
	var i, tabcontent, tablinks;

	tabcontent = document.getElementsByClassName("tabcontent");
	for(i=0; i<tabcontent.length; i++){
		tabcontent[i].style.display = " none";
	}

	tablinks = document.getElementsByClassName("tablinks");
	for(i=0; i<tablinks.length; i++){
		tablinks[i].className = tablinks[i].className.replace(" active", "");
	}

	if(tabId == 'Youtube'){

		document.getElementById('display_videos_youtube').style.display=" none";
		document.getElementById('loader_youtube').style.display="block";
		document.getElementById('display_videos_youtube').innerHTML='';
		document.getElementById("nav_bar").style.display = "none";
		document.getElementById("footerY").style.display="none";

		if(document.getElementById('big_search_button').classList.contains("not_pressed")){
			getYoutubeFeed("feed.php");
		}else{
			getYoutubeFeed("makeRequestApi.php");
		}

		tablinks[1].className += " active";
	}else if(tabId == 'Instagram'){

		document.getElementById('display_videos_instagram').style.display=" none";
		document.getElementById('loader_instagram').style.display="block";
		document.getElementById('display_videos_instagram').innerHTML='';
		document.getElementById("nav_bar").style.display = "none";
		document.getElementById("footerI").style.display="none";

		if(document.getElementById('big_search_button').classList.contains("not_pressed")){
			getInstagramFeed("feed.php");
		}else{
			getInstagramFeed("makeRequestApi.php");
		}
		tablinks[2].className += " active";

	}else if(tabId == 'Vimeo'){

		document.getElementById('display_videos_vimeo').style.display=" none";
		document.getElementById('loader_vimeo').style.display="block";
		document.getElementById('display_videos_vimeo').innerHTML='';
		document.getElementById("nav_bar").style.display = "none";
		document.getElementById("footerV").style.display="none";

		if(document.getElementById('big_search_button').classList.contains("not_pressed")){
			getVimeoFeed("feed.php");
		}else{
			getVimeoFeed("makeRequestApi.php");
		}

		tablinks[3].className += " active";

	}else if(tabId == 'Account'){
		tablinks[5].className += " active";
	}else if(tabId == 'Criterias'){
		tablinks[0].className += " active";
	}else{
		var row = createLibraryRow();
		var column
		for(var i=0;i<4;i++){
			column = createLibraryColumn();
			row.appendChild(column);
		}
		document.getElementById('saved_media').innerHTML = '';
		getYoutubeLibraryRequest(row);
		getVimeoLibraryRequest(row);
		getInstagramLibraryRequest(row);
		tablinks[4].className += " active";
	}

	document.getElementById(tabId).style.display="block";
}

function getInstagramFeed(option){
	var items = 3;
	var params = {};
	if(option == "feed.php"){
		params = {
			"user_id" : user_id
		};
	}else{
		params = {
			"user_id" : user_id,
			"query_params" : search_params
		};
	}

	var json_params = JSON.stringify(params);
	var newsHttp = new XMLHttpRequest();
	var instagram_media_row = createLibraryRow();
	var column;
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var videos = JSON.parse(this.responseText); 

			for(var index = 0;index < 4; index++){
				column = createLibraryColumn();
				instagram_media_row.appendChild(column);
			}

			for(var index=0;index<videos.data.length;index++){
					
				var media_image = createLibraryImageInstagram(videos.data[index] + "/media");
				//var media_image = createLibraryImageInstagram("https://www.instagram.com/p/B_5gFRlgtlJ/media");
				var instagram_media = createLibraryDiv();
				var media_functions = createLibraryFunctions();
				media_functions.id = videos.data[index];
				//media_functions.id = "https://www.instagram.com/p/B_5gFRlgtlJ";


				instagram_media.onmouseover = function(){
					this.children[0].style.opacity = " 0.5";
					this.children[1].style.opacity = "1";
				}
				instagram_media.onmouseout = function(){
					this.children[1].style.opacity = " 0";
					this.children[0].style.opacity = "1";
				}

				media_functions.getElementsByTagName("i")[0].className = "";
				media_functions.getElementsByTagName("i")[0].className = "fa fa-heart";

				media_functions.getElementsByTagName("i")[0].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onclick = function(){
					saveInstagramVideo(user_id, this.parentNode.parentNode.parentNode.id);
					document.getElementById("nav_bar").style.display = "none";
					document.getElementById("footerI").style.display="none";
				}
				media_functions.getElementsByTagName("i")[1].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onclick = function(){
					var view = viewInstagramMedia(this.parentNode.parentNode.parentNode.id);
					document.getElementById("view_media_html_instagram").appendChild(view);
					document.getElementById("view_media_instagram").style.display="block";
					document.getElementById("nav_bar").style.display = "none";
					document.getElementById("footerI").style.display="none";
				}

				instagram_media.appendChild(media_image);
				instagram_media.appendChild(media_functions);
				instagram_media_row.children[index%4].appendChild(instagram_media);
			}
			document.getElementById("display_videos_instagram").appendChild(instagram_media_row);
			document.getElementById("display_videos_instagram").style.display="block";
			document.getElementById("loader_instagram").style.display="none";
			document.getElementById("nav_bar").style.display = "block";
			document.getElementById("footerI").style.display="block";
			checkWidth();
		}
	}

	resize();
	newsHttp.open("POST", "http://localhost/project/sivir_api/api/instagram/"+option, true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);

}


function embeddingInstagramMedia(media_url){

	var instagram_video = document.createElement("div");
	instagram_video.style.position="absolute";
	instagram_video.style.marginLeft = "15%";
	instagram_video.style.marginRight = "30%";
	instagram_video.style.top = "2%";
	instagram_video.style.bottom = "2%";
	instagram_video.style.width = " 45%";
	instagram_video.style.display = "block";
	instagram_video.id = media_url;

	var embeddHttp = new XMLHttpRequest();
	embeddHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var item = JSON.parse(this.responseText);
			instagram_video.innerHTML = item.html;
			instgrm.Embeds.process();
	
		}
	}
	embeddHttp.open("GET", "https://api.instagram.com/oembed?omitscript=true&minwidth=477&maxwidth=500&hidecaption=true&url=" + media_url, true);
	embeddHttp.send();
	return instagram_video;
}

function getVimeoFeed(option){
	var params = {};
	if(option == "feed.php"){
		params = {
			"user_id" : user_id
		};
	}else{
		params = {
			"user_id" : user_id,
			"query_params" : search_params
		};
	}

	var json_params = JSON.stringify(params);
	var vimeo_media_row = createLibraryRow();
	var column;
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){

			var videos = JSON.parse(this.responseText);
			for(var index = 0;index < 4; index++){
				column = createLibraryColumn();
				vimeo_media_row.appendChild(column);
			}
			for(var index=0;index<videos.data.length;index++){

				var media_id = videos.data[index];
				var media_image = createLibraryImageVimeo(media_id);
				var vimeo_media = createLibraryDiv();
				var media_functions = createLibraryFunctions();
				media_functions.id = "https://player.vimeo.com/video/" + videos.data[index];


				vimeo_media.onmouseover = function(){
					this.children[0].style.opacity = " 0.5";
					this.children[1].style.opacity = "1";
				}
				vimeo_media.onmouseout = function(){
					this.children[1].style.opacity = " 0";
					this.children[0].style.opacity = "1";
				}

				media_functions.getElementsByTagName("i")[0].className = "";
				media_functions.getElementsByTagName("i")[0].className = "fa fa-heart";

				media_functions.getElementsByTagName("i")[0].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onclick = function(){
					saveVimeoVideo(user_id, this.parentNode.parentNode.parentNode.id);
					document.getElementById("nav_bar").style.display = "none";
					document.getElementById("footerV").style.display="none";
				}
				media_functions.getElementsByTagName("i")[1].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onclick = function(){
					var view = viewVimeoMedia(this.parentNode.parentNode.parentNode.id);
					var view_media_object = document.getElementById("view_media_html_vimeo");
					view_media_object.style.position = " absolute";
					view_media_object.style.top = " 10%";
					view_media_object.style.bottom = " 10%";
					view_media_object.style.left = " 10%";
					view_media_object.style.right = " 10%";
					view_media_object.appendChild(view);
					document.getElementById("view_media_vimeo").style.display="block";
					document.getElementById("nav_bar").style.display = "none";
					document.getElementById("footerV").style.display="none";
				}

				vimeo_media.appendChild(media_image);
				vimeo_media.appendChild(media_functions);

				vimeo_media_row.children[index%4].appendChild(vimeo_media);
			}
			document.getElementById("display_videos_vimeo").appendChild(vimeo_media_row);
			document.getElementById("display_videos_vimeo").style.display=" block";
			document.getElementById("loader_vimeo").style.display=" none";
			document.getElementById("nav_bar").style.display = "block";
			document.getElementById("footerV").style.display="block";
			checkWidth();
		}
	}

	resize();

	newsHttp.open("POST", "http://localhost/project/sivir_api/api/vimeo/"+option, true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}


function getYoutubeFeed(option){
	var params = {};
	if(option == "feed.php"){
		params = {
			"user_id" : user_id,
			"pageNo" : 1
		};
	}else{
		params = {
			"user_id" : user_id,
			"query_params" : search_params
		};
	}
	var youtube_media_row = createLibraryRow();
	var column;
	var json_params = JSON.stringify(params);
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var videos = JSON.parse(this.responseText);

			for(var index = 0;index < 4; index++){
				column = createLibraryColumn();
				youtube_media_row.appendChild(column);
			}

			for(var index=0;index<videos.data.length;index++){


				var media_id = videos.data[index];
				var image_src = "https://img.youtube.com/vi/" + media_id + "/0.jpg";
				var media_image = createLibraryImageYoutube(image_src);
				var youtube_media = createLibraryDiv();
				var media_functions = createLibraryFunctions();
				media_functions.id = "https://www.youtube.com/embed/" + videos.data[index];


				youtube_media.onmouseover = function(){
					this.children[0].style.opacity = " 0.5";
					this.children[1].style.opacity = "1";
				}
				youtube_media.onmouseout = function(){
					this.children[1].style.opacity = " 0";
					this.children[0].style.opacity = "1";
				}

				media_functions.getElementsByTagName("i")[0].className = "";
				media_functions.getElementsByTagName("i")[0].className = "fa fa-heart";

				media_functions.getElementsByTagName("i")[0].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onclick = function(){
					saveYoutubeVideo(user_id, this.parentNode.parentNode.parentNode.id);
					document.getElementById("nav_bar").style.display = "none";
					document.getElementById("footerY").style.display="none";
				}
				media_functions.getElementsByTagName("i")[1].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onclick = function(){
					var view = viewYoutubeMedia(this.parentNode.parentNode.parentNode.id);
					var view_media_object = document.getElementById("view_media_html_youtube");
					view_media_object.style.position = " absolute";
					view_media_object.style.top = " 10%";
					view_media_object.style.bottom = " 10%";
					view_media_object.style.left = " 10%";
					view_media_object.style.right = " 10%";
					view_media_object.appendChild(view);
					document.getElementById("view_media_youtube").style.display="block";
					document.getElementById("nav_bar").style.display = "none";
					document.getElementById("footerY").style.display="none";
				}

				youtube_media.appendChild(media_image);
				youtube_media.appendChild(media_functions);

				youtube_media_row.children[index%4].appendChild(youtube_media);

			}
			document.getElementById("display_videos_youtube").appendChild(youtube_media_row);
			document.getElementById('display_videos_youtube').style.display=" block";
			document.getElementById('loader_youtube').style.display="none";
			document.getElementById("nav_bar").style.display = "block";
			document.getElementById("footerY").style.display="block";
			checkWidth();
		}
	}

	resize();

	newsHttp.open("POST", "http://localhost/project/sivir_api/api/youtube/"+option, true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}


/*request - POST => save vimeo video*/
function saveVimeoVideo(user_id, video_url){
	var params = {
		"user_id" : user_id,
		"video_url" : video_url
	};

	var json_params = JSON.stringify(params);
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('save_confirmation_vimeo').style.display=" block";
		}
	}
	newsHttp.open("POST", "http://localhost/project/sivir_api/api/vimeo/create.php", true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}

/*request - POST => save youtube video*/
function saveYoutubeVideo(user_id, video_id){
	var params = {
		"user_id" : user_id,
		"video_url" : video_id
	};

	var json_params = JSON.stringify(params);
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('save_confirmation_youtube').style.display=" block";
		}
	}
	newsHttp.open("POST", "http://localhost/project/sivir_api/api/youtube/create.php", true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}

/*request - POST => save instagram video*/
function saveInstagramVideo(user_id, video_url){
	var params = {
		"user_id" : user_id,
		"video_url" : video_url
	};

	var json_params = JSON.stringify(params);
	var reqHttp = new XMLHttpRequest();
	reqHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('save_confirmation_instagram').style.display=" block";
		}
	}
	reqHttp.open("POST", "http://localhost/project/sivir_api/api/instagram/create.php", true);
	reqHttp.setRequestHeader("Content-type","application/json");
	reqHttp.send(json_params);
}

function displayOption(optionId){
	
	document.getElementById("user_options_input_id").style.display = "block";
	document.getElementById(optionId).style.display = "block";
	document.getElementById("change_profile_pic_confirm").style.display = "none";
	document.getElementById("change_profile_pic_error").style.display = "none";
	document.getElementById("change_password_confirm").style.display = "none";
	document.getElementById("change_password_error").style.display = "none";
	document.getElementById("change_email_confirm").style.display = "none";
	document.getElementById("change_email_error").style.display = "none";
	document.getElementById("change_username_confirm").style.display = "none";
	document.getElementById("change_username_error").style.display = "none";
	document.getElementById("change_password_confirm").style.display = "none";
	document.getElementById("change_password_error").style.display = "none";
}


function hideOption(optionId){
	document.getElementById(optionId).style.display = "none";
	document.getElementById("user_options_input_id").style.display = "none";
}


function confirmationHideOption(optionId){
	document.getElementById(optionId).style.display = "none";
	document.getElementById("user_options_input_id").style.display = "none";
	location.replace("http://localhost/project/sivir/account.php?account_info_display=1");
}

/*hide save-video confirmation*/
function hideConfirmationSave(elementId, footer){
	document.getElementById(elementId).style.display=" none";
	document.getElementById("nav_bar").style.display="block";
	document.getElementById(footer).style.display="block";
}

/*hide delete-video confirmation*/
function hideConfirmationDelete(elementId){
	document.getElementById(elementId).style.display=" none";
	document.getElementById("nav_bar").style.display="block";
}

/*setter for session id*/
function setSessionUserId(value){
	user_id = value;
}

/*display videos from youtube in library*/
function getYoutubeLibraryRequest(row){
	var params = {
		"user_id" : user_id
	};
	var json_params = JSON.stringify(params);
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var library = JSON.parse(this.responseText);

			for(var index=0;index<library.videos.length;index++){

				var media_id = library.videos[index].substring(library.videos[index].lastIndexOf('/') + 1);
				var image_src = "https://img.youtube.com/vi/" + media_id + "/0.jpg";
				var media_image = createLibraryImageYoutube(image_src);
				var youtube_media = createLibraryDiv();
				var media_functions = createLibraryFunctions();
				media_functions.id = library.videos[index];


				youtube_media.onmouseover = function(){
					this.children[0].style.opacity = " 0.5";
					this.children[1].style.opacity = "1";
				}
				youtube_media.onmouseout = function(){
					this.children[1].style.opacity = " 0";
					this.children[0].style.opacity = "1";
				}

				media_functions.getElementsByTagName("i")[0].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onclick = function(){
					deleteYoutubeMedia(user_id, this.parentNode.parentNode.parentNode.id);
					document.getElementById("nav_bar").style.display = "none";
				}
				media_functions.getElementsByTagName("i")[1].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onclick = function(){
					var view = viewYoutubeMedia(this.parentNode.parentNode.parentNode.id);
					var view_media_object = document.getElementById("view_media_html");
					view_media_object.style.position = " absolute";
					view_media_object.style.top = " 10%";
					view_media_object.style.bottom = " 10%";
					view_media_object.style.left = " 10%";
					view_media_object.style.right = " 10%";
					view_media_object.appendChild(view);
					document.getElementById("view_media").style.display="block";
					document.getElementById("nav_bar").style.display = "none";
				}

				youtube_media.appendChild(media_image);
				youtube_media.appendChild(media_functions);

				row.children[index%4].appendChild(youtube_media);
			}
			checkWidth();
			document.getElementById("saved_media").appendChild(row);
		}
	}
	resize();
	newsHttp.open("POST", "http://localhost/project/sivir_api/api/youtube/getVideos.php", true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}

/*display videos from vimeo in library*/
function getVimeoLibraryRequest(row){
	var params = {
		"user_id" : user_id
	};
	var json_params = JSON.stringify(params);
	
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var library = JSON.parse(this.responseText);

			for(var index=0;index<library.videos.length;index++){
				
				var media_id = library.videos[index].substring(library.videos[index].lastIndexOf('/') + 1);
				var media_image = createLibraryImageVimeo(media_id);
				var vimeo_media = createLibraryDiv();
				var media_functions = createLibraryFunctions();
				media_functions.id = library.videos[index];


				vimeo_media.onmouseover = function(){
					this.children[0].style.opacity = " 0.5";
					this.children[1].style.opacity = "1";
				}
				vimeo_media.onmouseout = function(){
					this.children[1].style.opacity = " 0";
					this.children[0].style.opacity = "1";
				}

				media_functions.getElementsByTagName("i")[0].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[0].onclick = function(){
					deleteVimeoMedia(user_id, this.parentNode.parentNode.parentNode.id);
					document.getElementById("nav_bar").style.display = "none";
				}
				media_functions.getElementsByTagName("i")[1].onmouseover = function(){
					this.style.transition = "0.3s";
					this.style.color = " red";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onmouseout = function(){
					this.style.transition = "0.3s";
					this.style.color = " orange";
					this.style.cursor = "pointer";
				}
				media_functions.getElementsByTagName("i")[1].onclick = function(){
					var view = viewVimeoMedia(this.parentNode.parentNode.parentNode.id);
					var view_media_object = document.getElementById("view_media_html");
					view_media_object.style.position = " absolute";
					view_media_object.style.top = " 10%";
					view_media_object.style.bottom = " 10%";
					view_media_object.style.left = " 10%";
					view_media_object.style.right = " 10%";
					view_media_object.appendChild(view);
					document.getElementById("view_media").style.display="block";
					document.getElementById("nav_bar").style.display = "none";
				}

				vimeo_media.appendChild(media_image);
				vimeo_media.appendChild(media_functions);

				row.children[index%4].appendChild(vimeo_media);
			}
			document.getElementById("saved_media").appendChild(row);
		}
	}
	resize();
	newsHttp.open("POST", "http://localhost/project/sivir_api/api/vimeo/getVideos.php", true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}


function getInstagramLibraryRequest(row){
	var params = {
		"user_id" : user_id
	};
	var json_params = JSON.stringify(params);
	
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var library = JSON.parse(this.responseText);
			for(var index=0;index<library.videos.length;index++){

					var media_image = createLibraryImageInstagram(library.videos[index] + "/media");
					var instagram_media = createLibraryDiv();
					var media_functions = createLibraryFunctions();
					media_functions.id = library.videos[index];


					instagram_media.onmouseover = function(){
						this.children[0].style.opacity = " 0.5";
						this.children[1].style.opacity = "1";
					}
					instagram_media.onmouseout = function(){
						this.children[1].style.opacity = " 0";
						this.children[0].style.opacity = "1";
					}

					media_functions.getElementsByTagName("i")[0].onmouseover = function(){
						this.style.transition = "0.3s";
						this.style.color = " red";
						this.style.cursor = "pointer";
					}
					media_functions.getElementsByTagName("i")[0].onmouseout = function(){
						this.style.transition = "0.3s";
						this.style.color = " orange";
						this.style.cursor = "pointer";
					}
					media_functions.getElementsByTagName("i")[0].onclick = function(){
						deleteInstagramMedia(user_id, this.parentNode.parentNode.parentNode.id);
						document.getElementById("nav_bar").style.display = "none";
					}
					media_functions.getElementsByTagName("i")[1].onmouseover = function(){
						this.style.transition = "0.3s";
						this.style.color = " red";
						this.style.cursor = "pointer";
					}
					media_functions.getElementsByTagName("i")[1].onmouseout = function(){
						this.style.transition = "0.3s";
						this.style.color = " orange";
						this.style.cursor = "pointer";
					}
					media_functions.getElementsByTagName("i")[1].onclick = function(){
						var view = viewInstagramMedia(this.parentNode.parentNode.parentNode.id);
						document.getElementById("view_media_html").appendChild(view);
						document.getElementById("view_media").style.display="block";
						document.getElementById("nav_bar").style.display = "none";
					}

					instagram_media.appendChild(media_image);
					instagram_media.appendChild(media_functions);

					row.children[index%4].appendChild(instagram_media);

			}document.getElementById("library_display_videos_instagram").appendChild(row);
		}
	}
	resize();
	newsHttp.open("POST", "http://localhost/project/sivir_api/api/instagram/getVideos.php", true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}

/* request - DELETE => delete youtube videos from library*/

function viewYoutubeMedia(media_url){
	var view = document.createElement("IFRAME");
	view.style.position = " absolute";
	view.style.top = " 0%";
	view.style.left = " 0%";
	view.style.right = " 0%";
	view.style.bottom = "0%";
	view.style.decoration = " none";
	view.style.border = " none";
	view.width = "100%";
	view.height = "100%";
	view.style.display = " block";
	view.setAttribute("src", media_url);
	return view;
}

function deleteYoutubeMedia(user_id, video_url){
	var params = {
		"user_id" : user_id,
		"video_url" : video_url
	};
	var json_params = JSON.stringify(params);
	
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('deleted_confirmation_youtube').style.display=" block";
			rebuilt();
		}
	}

	newsHttp.open("DELETE", "http://localhost/project/sivir_api/api/youtube/delete.php", true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}

/* request - DELETE => delete vimeo videos from library*/

function viewVimeoMedia(media_url){
	var view = document.createElement("IFRAME");
	view.style.position = " absolute";
	view.style.top = " 0%";
	view.style.left = " 0%";
	view.style.right = " 0%";
	view.style.bottom = "0%";
	view.style.decoration = " none";
	view.style.border = " none";
	view.width = "100%";
	view.height = "100%";
	view.style.display = " block";
	view.setAttribute("src", media_url);
	return view;

}

function deleteVimeoMedia(user_id, video_url){
	var params = {
		"user_id" : user_id,
		"video_url" : video_url
	};
	var json_params = JSON.stringify(params);
	var newsHttp = new XMLHttpRequest();
	newsHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById('deleted_confirmation_vimeo').style.display=" block";
			rebuilt();
		}
	}

	newsHttp.open("DELETE", "http://localhost/project/sivir_api/api/vimeo/delete.php", true);
	newsHttp.setRequestHeader("Content-type","application/json");
	newsHttp.send(json_params);
}

/* request - DELETE => delete instagram videos from library*/

function viewInstagramMedia(media_url){
	var view = document.createElement("DIV");
	view.style.position = " absolute";
	view.style.top = " 0%";
	view.style.width = " 50%";
	view.style.left = " 25%";
	view.style.display = " block";
	view.style.overflow = " auto";

	var embeddHttp = new XMLHttpRequest();
	embeddHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var item = JSON.parse(this.responseText);
			view.innerHTML = item.html;
			instgrm.Embeds.process();
	
		}
	}

	embeddHttp.open("GET", "https://api.instagram.com/oembed?omitscript=true&minwidth=477&maxwidth=500&hidecaption=true&url=" + media_url, true);
	embeddHttp.send();

	return view;

}

function deleteInstagramMedia(user_id, video_url){
	var params = {
		"user_id" : user_id,
		"video_url" : video_url
	};

	var json_params = JSON.stringify(params);

	var reqHttp = new XMLHttpRequest();

	reqHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			document.getElementById("deleted_confirmation_instagram").style.display=" block";
			rebuilt();
		}
	}

	reqHttp.open("DELETE", "http://localhost/project/sivir_api/api/instagram/delete.php", true);
	reqHttp.setRequestHeader("Content-type","application/json");
	reqHttp.send(json_params);

}

function checkWidth(){
	if(window.innerWidth <= 1300 && window.innerWidth > 1100){
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="30%";
				elems[i].style.maxWidth="30%";
			}
			var row = document.getElementById("data_row");
			row.style.width = "100%";
			row.style.left = "0%";
			document.getElementById("nav_bar").style.left = "90%";
		} else if(window.innerWidth <= 1300 && window.innerWidth > 800){
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="50%";
				elems[i].style.maxWidth="50%";
			}

			var row = document.getElementById("data_row");
			row.style.width = "82%";
			row.style.left = "5%";
			document.getElementById("nav_bar").style.left = "85%";
		}
		else if(window.innerWidth <= 800){
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="100%";
				elems[i].style.maxWidth="100%";
			}
			var row = document.getElementById("data_row");
			row.style.width = "100%";
			row.style.left = "0%";
			document.getElementById("nav_bar").style.left = "85%";
		}
		else{
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="25%";
				elems[i].style.maxWidth="25%";
			}
			var row = document.getElementById("data_row");
			row.style.width = "100%";
			row.style.left = "0%";
			document.getElementById("nav_bar").style.left = "0%";
		}
}


function resize(){
	window.onresize = function(){
		if(window.innerWidth <= 1300 && window.innerWidth > 1100){
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="30%";
				elems[i].style.maxWidth="30%";
			}
			var row = document.getElementById("data_row");
			row.style.width = "100%";
			row.style.left = "0%";
			document.getElementById("nav_bar").style.left = "90%";
		} else if(window.innerWidth <= 1300 && window.innerWidth > 800){
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="50%";
				elems[i].style.maxWidth="50%";
			}

			var row = document.getElementById("data_row");
			row.style.width = "82%";
			row.style.left = "5%";
			document.getElementById("nav_bar").style.left = "85%";
		}
		else if(window.innerWidth <= 800){
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="100%";
				elems[i].style.maxWidth="100%";
			}
			var row = document.getElementById("data_row");
			row.style.width = "100%";
			row.style.left = "0%";
			document.getElementById("nav_bar").style.left = "85%";
		}
		else{
			var elems = document.getElementsByClassName("column");
			for(var i=0;i<elems.length;i++){
				elems[i].style.flex="25%";
				elems[i].style.maxWidth="25%";
			}
			var row = document.getElementById("data_row");
			row.style.width = "100%";
			row.style.left = "0%";
			document.getElementById("nav_bar").style.left = "0%";
		}
	}
}

function rebuilt(){
	document.getElementById("saved_media").innerHTML = '';
	var row = createLibraryRow();
	for(var i=0;i<4;i++){
		var column = createLibraryColumn();
		row.appendChild(column);
	}
	getInstagramLibraryRequest(row);
	getVimeoLibraryRequest(row);
	getYoutubeLibraryRequest(row);
}

function createLibraryImageYoutube(imageSrc){
	var image = document.createElement("IMG");
	image.style.width = "330px";
	image.style.visibility = " visible";
	image.style.opacity = " 1";
	image.style.transition = "opacity .35s ease-in-out";
	image.src = imageSrc;
	return image;
}


function createLibraryImageInstagram(imageSrc){
	var image = document.createElement("IMG");
	image.style.width = "320px";
	image.style.visibility = " visible";
	image.style.opacity = " 1";
	image.src = imageSrc;
	image.style.transition = "opacity .35s ease-in-out";
	return image;
}

function createLibraryImageVimeo(mediaId){

	var image = document.createElement("IMG");
	image.style.width = "320px";
	image.style.visibility = " visible";
	image.style.opacity = " 1";
	image.style.transition = "opacity .35s ease-in-out";

	


	var reqImg = new XMLHttpRequest();

	reqImg.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var image_url = this.responseText;
			image_url = image_url.substring(1, image_url.length - 1);
			image_url = JSON.parse(image_url);
			image.src = image_url.thumbnail_large;
		}
	}

	reqImg.open("GET", "http://vimeo.com/api/v2/video/"+mediaId+".json",true);
	reqImg.send();
	return image;
}

function createLibraryDiv(){
	var element = document.createElement("DIV");
	element.style.position = "relative";
	return element;
}

function createLibraryColumn(){
	var element = document.createElement("DIV");
	element.style.flex = "25%";
	element.style.maxWidth = "25%";
	element.classList.add("column");
	return element;
}

function createLibraryRow(){
	var row = document.createElement("DIV");
	row.style.position = "absolute";
	row.style.top = "15%";
	row.style.right = "0%"
	row.style.left = "0%";
	row.style.width = "100%";
	row.style.display = "flex";
	row.style.flexWrap = "wrap";
	row.style.textAlign = "center";
	row.id = "data_row";
	return row;
}

function createLibraryFunctions(){
	var functions = document.createElement("DIV");
	var elements = document.createElement("DIV");

	var delete_icon = "<i class='fa fa-trash'></i>";
	var view_icon = "<i class='fa fa-eye'></i>";

	var delete_div = document.createElement("DIV");
	delete_div.innerHTML = delete_icon;
	delete_div.style.position = "absolute";
	delete_div.style.top = "30%";
	delete_div.style.bottom = "30%";
	delete_div.style.left = "50%";
	delete_div.style.right = "5%";
	delete_div.style.textAlign = "center";
	delete_div.style.display = "block";
	delete_div.style.fontSize = " 50px";
	delete_div.style.color = " orange";
	delete_div.style.id = "instagram_library_delete_media";

	var view_div = document.createElement("DIV");
	view_div.innerHTML = view_icon;
	view_div.style.position = "absolute";
	view_div.style.top = "30%";
	view_div.style.bottom = "30%";
	view_div.style.left = "5%";
	view_div.style.right = "50%";
	view_div.style.textAlign = "center";
	view_div.style.display = "block";
	view_div.style.fontSize = " 50px";
	view_div.style.color = " orange";
	view_div.style.id = "instagram_library_view_media";

	functions.style.textAlign = "center";
	functions.style.display = " block";
	functions.style.width = "100%";
	functions.style.height = "100%";
	functions.style.backgroundColor = "rgba(0,0,0,0.6)";
	functions.style.top = "0%";
	functions.style.bottom = "0%";
	functions.style.left = "0%";
	functions.style.right = "0%";
	functions.style.visibility = " visible";
	functions.style.opacity = " 0";
	functions.style.transition = "opacity .35s ease-in-out";


	elements.style.textAlign = " center";
	elements.style.display = " block";
	elements.style.position = " absolute";
	elements.style.top = "5%";
	elements.style.bottom = "5%";
	elements.style.left = "5%";
	elements.style.right = "5%";
	elements.appendChild(delete_div);
	elements.appendChild(view_div);

	functions.appendChild(elements);

	return functions;
}

function hideView(view_id, footer){
	document.getElementById("view_media_html").innerHTML = "";
	document.getElementById("view_media_html_instagram").innerHTML = "";
	document.getElementById("view_media_html_vimeo").innerHTML = "";
	document.getElementById("view_media_html_youtube").innerHTML = "";
	document.getElementById(view_id).style.display = " none";
	document.getElementById("nav_bar").style.display = "block";
	if(footer.localeCompare('none') != 0){
		document.getElementById(footer).style.display="block";
	}
}

function setParams(){
	var emotion = document.getElementById("emotion");
	var title = document.getElementById("title");
	var country = document.getElementById("country");
	var length = document.getElementById("length");
	var tags = document.getElementById("tags");
	var description = document.getElementById("description");
	var size = 0;
	
	if(emotion.value){
		search_params["emotion"] = emotion.value;
		size++;
	}else{
		search_params["emotion"] = "none";
	}

	if(title.value){
		search_params["title"] = title.value;
		size++;
	}else{
		search_params["title"] = "none";
	}

	if(country.value){
		search_params["country"] = country.value;
		size++;
	}else{
		search_params["country"] = "none";
	}

	if(length.value){
		search_params["length"] = length.value;
		size++;
	}else{
		search_params["length"] = "none";
	}

	if(tags.value){
		search_params["tags"] = tags.value;
		size++;
	}else{
		search_params["tags"] = "none";
	}

	if(description.value){
		search_params["description"] = description.value;
		size++;
	}else{
		search_params["description"] = "none";
	}

	var search_settings = document.getElementById("big_search_button");

	if(size != 0){
		if(search_settings.textContent == "Apply"){
			search_settings.classList.remove("not_pressed");
			search_settings.classList.add("pressed");
			search_settings.innerHTML = "Discharge";
		}else if(search_settings.textContent == "Discharge"){
			search_settings.classList.remove("pressed");
			search_settings.classList.add("not_pressed");
			search_settings.innerHTML = "Apply";
			emotion.value = "";
			title.value="";
			length.value="";
			country.value="";
			tags.value="";
			description.value="";
		}
	}else if(size == 0){
		if(search_settings.textContent == "Discharge"){
			search_settings.classList.remove("pressed");
			search_settings.classList.add("not_pressed");
			search_settings.innerHTML = "Apply";
			emotion.value = "";
			title.value="";
			length.value="";
			country.value="";
			tags.value="";
			description.value="";
		}else if(search_settings.textContent == "Apply"){
			document.getElementById("search_settings_window").style.display="block";
		}
	}
}

function signout(){
	window.location.assign("../sivir/php/logout.php");
}

function quickSearchInstagram(){
	var value = document.getElementById('ifooter_tag').value;
	if(value){
		document.getElementById('display_videos_instagram').style.display=" none";
		document.getElementById('loader_instagram').style.display="block";
		document.getElementById('display_videos_instagram').innerHTML='';
		document.getElementById("nav_bar").style.display = "none";
		document.getElementById("footerI").style.display="none";
		search_params["tags"] = value;
		search_params["emotion"] = "none";
		search_params["title"] = "none";
		search_params["country"] = "none";
		search_params["length"] = "none";
		search_params["description"] = "none";
		getInstagramFeed("makeRequestApi.php");
	}else{
		alert("You should type a tag");
	}
}

function quickSearchVimeo(){
	var value = document.getElementById('vfooter_tag').value;
	if(value){
		document.getElementById('display_videos_vimeo').style.display=" none";
		document.getElementById('loader_vimeo').style.display="block";
		document.getElementById('display_videos_vimeo').innerHTML='';
		document.getElementById("nav_bar").style.display = "none";
		document.getElementById("footerV").style.display="none";
		search_params["tags"] = value;
		search_params["emotion"] = "none";
		search_params["title"] = "none";
		search_params["country"] = "none";
		search_params["length"] = "none";
		search_params["description"] = "none";
		getVimeoFeed("makeRequestApi.php");
	}else{
		alert("You should type a tag");
	}
}

function quickSearchYoutube(){
	var value = document.getElementById('yfooter_tag').value;
	if(value){
		document.getElementById('display_videos_youtube').style.display=" none";
		document.getElementById('loader_youtube').style.display="block";
		document.getElementById('display_videos_youtube').innerHTML='';
		document.getElementById("nav_bar").style.display = "none";
		document.getElementById("footerY").style.display="none";
		search_params["tags"] = value;
		search_params["emotion"] = "none";
		search_params["title"] = "none";
		search_params["country"] = "none";
		search_params["length"] = "none";
		search_params["description"] = "none";
		getYoutubeFeed("makeRequestApi.php");
	}else{
		alert("You should type a tag");
	}
}