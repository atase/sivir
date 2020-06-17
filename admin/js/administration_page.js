var adminToken;

function setAdminToken(value){
	adminToken = value;
}


function launch_project(){
	window.open('http://localhost/project/sivir/index.php', '_blank');
}

function launch_phpmyadmin(){
	window.open('http://localhost/phpmyadmin/','_blank'); 
}

function view_api_structure(){
	document.getElementById("view").style.display="block";
	document.getElementById("structure_viewer").style.display="block";
	var writer = document.getElementById("strviewer");
	var row;
	var message = createCodeViewMessage("Select a file...");
	var view = createStructureViewer();
	writer.appendChild(view);
	var leftWriter = writer.children[0].children[0];
	writer.children[0].children[1].appendChild(message);
	var structureHttp = new XMLHttpRequest();
	structureHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){

			var data = JSON.parse(this.responseText);
			row = createRow("fa fa-folder", data.result.structure, 0);
			leftWriter.appendChild(row);
			for(var i=0;i<data.result.structure.files.length;i++){
				row = createRow("fa fa-file", data.result.structure.files[i], 5);
				leftWriter.appendChild(row);
			}
			writeStructure(data.result.structure.folders, leftWriter, 5);
		}
	}

	structureHttp.open("GET", "http://localhost/project/sivir_api/api/admin/apiStructure.php", true);
	structureHttp.setRequestHeader("Content-type","application/json");
	structureHttp.send();
}


function writeStructure(folders, writer, padding){
	var row;
	for(var index=0;index<folders.length;index++){
		row = createRow("fa fa-folder", folders[index], padding+5);
		writer.appendChild(row);
		for(var i=0;i<folders[index].files.length;i++){
			row = createRow("fa fa-file", folders[index].files[i], padding+10);
			writer.appendChild(row);
		}

		if(folders[index].folders.length != 0){
			writeStructure(folders[index].folders, writer, padding+5);
		}
	}
}

function createRow(type, obj, padding){
	var code = document.createElement("p");
	code.innerText = obj.data;
	code.style.display = "none";
	var row = document.createElement("p");
	var sentence = "<p><i class='" + type + "''></i> "+obj.path+"</p>";
	row.innerHTML = sentence;
	row.appendChild(code);
	row.style.color = "#101820FF";
	if(type == "fa fa-file"){
		row.children[0].children[0].style.color = "#101820FF";
	}else{
		row.children[0].children[0].style.color = "#DAA03DFF";
	}
	row.style.fontFamily = "Times New Roman, Times, serif";
	row.style.marginLeft = padding+"px";

	row.onmouseover = function(){
		this.style.cursor = "pointer";
		this.style.color = "red";
	}

	row.onmouseout = function(){
		this.style.color = "#101820FF";
	}

	row.onclick = function(){
		var rightWriter = document.getElementById("codeView");
		var parent = this.parentNode;
		if(window.innerWidth <= 1200){
			if(parent.style.display = "block"){
				parent.style.display = "none";
				rightWriter.style.display = "block";
			}
		}
		if(this.children[0].children[0].classList.contains("fa-file")){
			rightWriter.innerHTML = "";
			rightWriter.innerHTML = this.children[1].innerHTML;
		}else{
			rightWriter.innerHTML = "";
			var message = createCodeViewMessage("Directory " + this.children[0].innerText);
			rightWriter.appendChild(message);
		}
	}
	return row;
}

function createCodeViewMessage(text){
	var view = document.createElement("div");
	view.style.position = "absolute";
	view.style.top = "30%";
	view.style.bottom = "30%";
	view.style.left = "20%";
	view.style.right = "20%";
	view.style.textAlign = "center";

	var message = document.createElement("p");
	message.innerText = text;
	message.style.fontSize = "27px";
	message.style.fontFamily = "Times New Roman, Times, serif";
	message.style.color = "#101820FF";

	view.appendChild(message);

	return view;
}

function createStructureViewer(){
	var leftView = document.createElement("div");
	leftView.style.position = "absolute";
	leftView.style.top = "0%";
	leftView.style.bottom = "5%";
	leftView.style.left = "0%";
	leftView.style.right = "80%";
	leftView.style.background = "white";
	leftView.style.overflow = "auto";

	var rightView = document.createElement("div");
	rightView.style.position = "absolute";
	rightView.style.top = "0%";
	rightView.style.bottom = "5%";
	rightView.style.paddingLeft = "3%";
	rightView.style.overflow = "auto";
	rightView.style.border = "2px solid black";
	rightView.id = "codeView";
	rightView.style.fontFamily = "Times New Roman, Times, serif";

	if(window.innerWidth <= 1200){
		leftView.style.display = "none";
		rightView.style.left = "3%";
		document.getElementById("selector").style.display = "block";
	}else{
		leftView.style.display = "block";
		rightView.style.left = "24%";
		document.getElementById("selector").style.display = "none";
	}

	if(window.innerWidth <= 1050){
		rightView.style.right = "5%";
	}else{
		rightView.style.right = "0%";
	}

	var view = document.createElement("div");
	view.position = "absolute";
	view.top = "0%";
	view.bottom = "0%";
	view.left = "0%";
	view.right = "0%";

	window.onresize = function(){

		if(window.innerWidth <= 1200){
			leftView.style.display = "none";
			rightView.style.left = "3%";
			document.getElementById("selector").style.display = "block";
		}else{
			leftView.style.display = "block";
			if(rightView.style.display == "none"){
				rightView.style.display = "block";
			}
			leftView.style.left = "0%";
			leftView.style.right = "80%";
			rightView.style.left = "24%";
			document.getElementById("selector").style.display = "none";
		}

		if(window.innerWidth <= 1050){
			rightView.style.right = "5%";
		}else{
			rightView.style.right = "0%";
		}
	}

	view.appendChild(leftView);
	view.appendChild(rightView);

	return view;

}

function view_project_structure(){
	document.getElementById("view").style.display="block";
	document.getElementById("structure_viewer").style.display="block";
	var writer = document.getElementById("strviewer");
	var view = createStructureViewer();
	var message = createCodeViewMessage("Select a file...");
	var row;
	writer.appendChild(view);
	var leftWriter = writer.children[0].children[0];
	writer.children[0].children[1].appendChild(message);
	var structureHttp = new XMLHttpRequest();
	structureHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){

			var data = JSON.parse(this.responseText);
			row = createRow("fa fa-folder", data.result.structure, 0);
			leftWriter.appendChild(row);
			for(var i=0;i<data.result.structure.files.length;i++){
				row = createRow("fa fa-file", data.result.structure.files[i], 5);
				leftWriter.appendChild(row);
			}
			writeStructure(data.result.structure.folders, leftWriter, 5);
		}
	}

	structureHttp.open("GET", "http://localhost/project/sivir_api/api/admin/projectStructure.php", true);
	structureHttp.setRequestHeader("Content-type","application/json");
	structureHttp.send();
}


function directory_backup(){
	document.getElementById("view").style.display="block";
	document.getElementById("action_viewer").style.display="block";
	var writer = document.getElementById("actviewer");
	var view = createPathView("project_backup", "Specify a folder name for project backup .");
	writer.appendChild(view);
}

function directory_restoration(){
	document.getElementById("view").style.display="block";
	document.getElementById("action_viewer").style.display="block";
	var writer = document.getElementById("actviewer");
	var view = createPathView("project_restoration", "Confirm your password");
	writer.appendChild(view);
}


function view_db_tables(){
	document.getElementById("view").style.display="block";
	document.getElementById("structure_viewer").style.display="block";
	requestDatabaseTables();
}


function view_db_export(){
	document.getElementById("view").style.display="block";
	document.getElementById("action_viewer").style.display="block";
	var writer = document.getElementById("actviewer");
	var view = createPathView("database_export", "Specify a folder name for database export");
	writer.appendChild(view);
}

function database_backup(){
	document.getElementById("view").style.display="block";
	document.getElementById("action_viewer").style.display="block";
	var writer = document.getElementById("actviewer");
	var view = createPathView("database_backup", "Specify a folder name for database backup");
	writer.appendChild(view);
}


function database_restoration(){
	document.getElementById("view").style.display="block";
	document.getElementById("action_viewer").style.display="block";
	var writer = document.getElementById("actviewer");
	var view = createPathView("database_restoration", "Confirm password");
	writer.appendChild(view);
}




function hideView(elemId){
	document.getElementById(elemId).style.display="none";
	document.getElementById("view").style.display="none";
	document.getElementById("actviewer").innerHTML = "";
	document.getElementById("strviewer").innerHTML = "";
}


function addAdmin(){
	document.getElementById("view").style.display="block";
	document.getElementById("action_viewer").style.display="block";
	var writer = document.getElementById("actviewer");
	var view = createDataView();
	writer.appendChild(view);
}

function createMessageView(text, glyph){
	var view = document.createElement("div");
	view.style.position = "absolute";
	view.style.top = "5%";
	view.style.bottom = "5%";
	view.style.left = "5%";
	view.style.right = "5%";
	view.style.textAlign = "center";

	var message = document.createElement("div");
	message.style.position = "absolute"
	if(window.innerHeight <= 400){
			message.style.top = "50%";
			message.style.fontSize = "22px";
		}else{
			message.style.top = "40%";
		}
	message.style.left = "0%";
	message.style.right = "0%";
	message.style.bottom = "0%";
	message.style.fontSize = "25px";
	message.style.fontFamily = "Times New Roman, Times, serif";
	message.style.color = "#101820FF";
	message.innerHTML = "<p>" + text + "</p>";

	var symbol = document.createElement("p");
	if(window.innerHeight <= 400){
			symbol.style.fontSize = "50px";
		}else{
			symbol.style.fontSize = "77px";
		}
	symbol.innerHTML = "<i class='" + glyph + "'></i>";
	if(glyph == "fa fa-check"){
		symbol.style.color = "green";
	}else{
		symbol.style.color = "red";
	}

	window.onresize = function(){
		if(window.innerHeight <= 400){
			message.style.top = "50%";
			message.style.fontSize = "22px";
			symbol.style.fontSize = "50px";
		}else{
			message.style.top = "45%";
			symbol.style.fontSize = "77px";
		}
	}

	view.appendChild(message);
	view.appendChild(symbol);

	return view;
}


function requestCreateAdmin(email, username, password){
	var params = {
		"token" : adminToken,
		"email" : email,
		"username" : username,
		"password" : password
	};

	params = JSON.stringify(params);

	var writer = document.getElementById("actviewer");
	writer.innerHTML = "";
	var message;
	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = JSON.parse(this.responseText);
			if(data.message == "200"){
				message = createMessageView("Admin register success !", "fa fa-check");
				writer.appendChild(message);
			}else{
				message = createMessageView("Admin register error !", "fa fa-bell");
				writer.appendChild(message);
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/create.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send(params);
}

function createDataView(){
	var view = document.createElement("div");
	view.style.position = "absolute";
	view.style.top = "5%";
	view.style.bottom = "5%";
	view.style.left = "5%";
	view.style.right = "5%";
	view.style.textAlign = "center";
	view.style.minHeight = "400px";

	var message = document.createElement("p");
	message.style.position = "absolute";
	message.style.fontSize = "25px";
	message.style.fontFamily = "Times New Roman, Times, serif";
	message.style.color = "#101820FF";
	message.innerHTML = "<p>Admin registration</p>";

	if(window.innerHeight <= 500){
			message.style.top = "0%";
		}else{
			message.style.top = "5%";
		}

		if(window.innerWidth <= 600){
			message.style.left = "0%";
			message.style.right = "0%";
		}else{
			message.style.left = "25%";
			message.style.right = "25%";
		}


	var data_input =  document.createElement("div")
	data_input.style.position = "absolute";
	data_input.style.top = "22%";
	data_input.style.bottom = "12%";
	data_input.style.left = "30%";
	data_input.style.right = "30%";
	data_input.style.textAlign = "center";

		if(window.innerWidth <= 700){
			data_input.style.left = "15%";
			data_input.style.right = "15%";
			data_input.style.width = "70%";
		}else{
			data_input.style.left = "30%";
			data_input.style.right = "30%";
			data_input.style.width = "40%";
		}

	var email = document.createElement("input");
	email.style.position = "absolute";
	if(window.innerHeight <= 500){
			email.style.top = "5%";
		}else{ 
			email.style.top = "20%";
		}

		if(window.innerWidth <= 700){
			email.style.left = "0%";
			email.style.right = "0%";
			email.style.width = "100%";
		}else{
			email.style.left = "10%";
			email.style.right = "10%";
			email.style.width = "80%";
		}
	email.style.height = "30px";
	email.style.border = "none";
	email.style.borderBottom = "2px solid #101820FF";
	email.style.paddingLeft = "2%";
	email.placeholder="Email "

	var username = document.createElement("input");
	username.style.position = "absolute";
	if(window.innerHeight <= 500){
			username.style.top = "10%";
		}else{ 
			username.style.top = "40%";
		}

		if(window.innerWidth <= 700){
			username.style.left = "0%";
			username.style.right = "0%";
			username.style.width = "100%";
		}else{
			username.style.left = "10%";
			username.style.right = "10%";
			username.style.width = "80%";
		}
	username.style.height = "30px";
	username.style.border = "none";
	username.style.borderBottom = "2px solid #101820FF";
	username.style.paddingLeft = "2%";
	username.type=" text";
	username.placeholder="Username "

	var password = document.createElement("input");
	password.style.position = "absolute";
	if(window.innerHeight <= 500){
			password.style.top = "15%";
		}else{ 
			password.style.top = "60%";
		}

		if(window.innerWidth <= 700){
			password.style.left = "0%";
			password.style.right = "0%";
			password.style.width = "100%";
		}else{
			password.style.left = "10%";
			password.style.right = "10%";
			password.style.width = "80%";
		}
	password.style.height = "30px";
	password.style.border = "none";
	password.style.borderBottom = "2px solid #101820FF";
	password.style.paddingLeft = "2%";
	password.type="password";
	password.placeholder="Password "


	data_input.appendChild(email);
	data_input.appendChild(username);
	data_input.appendChild(password);

	var button = document.createElement("button");
	button.innerHTML = "Submit";
	button.style.position = "absolute";
	if(window.innerHeight <= 500){
			button.style.top = "90%";
		}else{
			button.style.top = "90%";
		}

		if(window.innerWidth <= 700){
			button.style.left = "30%";
			button.style.right = "30%";
			button.style.width = "40%";
		}else{
			button.style.left = "39%";
			button.style.right = "39%";
			button.style.width = "22%";
		}
	button.style.height = "30px";
	button.style.border = "none";
	button.style.outline = "none";
	button.style.cursor = "pointer";
	button.style.background = "#101820FF";
	button.style.color = "#DAA03DFF"; 
	button.style.transition = "0.3s";


	button.onmouseover = function(){
		this.style.color = "#101820FF";
		this.style.background = "#DAA03DFF";
	}
	button.onmouseout = function(){
		this.style.background = "#101820FF";
		this.style.color = "#DAA03DFF"; 
	}

	button.onclick = function(){
		if(email.value && username.value && password.value){
			requestCreateAdmin(email.value, username.value, password.value);
		}else{
			alert("Data is not entered!");
		}
	};

	window.onresize = function(){
		if(window.innerHeight <= 500){
			message.style.top = "0%";
		}else{
			message.style.top = "0%";
		}

		if(window.innerWidth <= 600){
			message.style.left = "0%";
			message.style.right = "0%";
		}else{
			message.style.left = "25%";
			message.style.right = "25%";
		}

		if(window.innerHeight <= 500){
			email.style.top = "10%";
			username.style.top = "30%";
			password.style.top = "50%";
		}else{ 
			email.style.top = "20%";
			username.style.top = "40%";
			password.style.top = "60%";
		}

		if(window.innerWidth <= 700){
			email.style.left = "15%";
			email.style.right = "15%";
			email.style.width = "70%";
			username.style.left = "15%";
			username.style.right = "15%";
			username.style.width = "70%";
			password.style.left = "15%";
			password.style.right = "15%";
			password.style.width = "70%";
		}else{
			email.style.left = "30%";
			email.style.right = "30%";
			email.style.width = "40%";
			username.style.left = "30%";
			username.style.right = "30%";
			username.style.width = "40%";
			password.style.left = "30%";
			password.style.right = "30%";
			password.style.width = "40%";
		}

		if(window.innerHeight <= 500){
			button.style.top = "90%";
		}else{
			button.style.top = "90%";
		}

		if(window.innerWidth <= 700){
			button.style.left = "30%";
			button.style.right = "30%";
			button.style.width = "40%";
		}else{
			button.style.left = "39%";
			button.style.right = "39%";
			button.style.width = "22%";
		}
	}

	view.appendChild(message);
	view.appendChild(data_input);
	view.appendChild(button);

	return view;

}

function createPathView(action, text){
	var view = document.createElement("div");
	view.style.position = "absolute";
	view.style.top = "5%";
	view.style.bottom = "5%";
	view.style.left = "5%";
	view.style.right = "5%";
	view.style.textAlign = "center";

	var message = document.createElement("p");
	message.style.position = "absolute";
	message.style.fontSize = "25px";
	message.style.fontFamily = "Times New Roman, Times, serif";
	message.style.color = "#101820FF";
	message.innerHTML = "<p>" + text + "</p>";
	if(window.innerHeight <= 500){
			message.style.top = "0%";
		}else{
			message.style.top = "10%";
		}

		if(window.innerWidth <= 600){
			message.style.left = "0%";
			message.style.right = "0%";
		}else{
			message.style.left = "25%";
			message.style.right = "25%";
		}

	var input = document.createElement("input");
	if((action.localeCompare("database_restoration") == 0) || (action.localeCompare("project_restoration") == 0)){
		input.setAttribute("type", "password");
	}else{
		input.setAttribute("type","text");
	}
	input.style.position = "absolute";
	if(window.innerHeight <= 500){
			input.style.top = "55%";
		}else{ 
			input.style.top = "50%";
		}

		if(window.innerWidth <= 700){
			input.style.left = "15%";
			input.style.right = "15%";
			input.style.width = "70%";
		}else{
			input.style.left = "30%";
			input.style.right = "30%";
			input.style.width = "40%";
		}
	input.style.height = "30px";
	input.style.border = "none";
	input.style.borderBottom = "2px solid #101820FF";
	input.style.paddingLeft = "2%";


	var button = document.createElement("button");
	button.innerHTML = "Submit";
	button.style.position = "absolute";
	if(window.innerHeight <= 500){
			button.style.top = "80%";
		}else{
			button.style.top = "70%";
		}

		if(window.innerWidth <= 700){
			button.style.left = "30%";
			button.style.right = "30%";
			button.style.width = "40%";
		}else{
			button.style.left = "39%";
			button.style.right = "39%";
			button.style.width = "22%";
		}
	button.style.height = "30px";
	button.style.border = "none";
	button.style.outline = "none";
	button.style.cursor = "pointer";
	button.style.background = "#101820FF";
	button.style.color = "#DAA03DFF"; 
	button.style.transition = "0.3s";


	button.onmouseover = function(){
		this.style.color = "#101820FF";
		this.style.background = "#DAA03DFF";
	}
	button.onmouseout = function(){
		this.style.background = "#101820FF";
		this.style.color = "#DAA03DFF"; 
	}

	button.onclick = function(){
		if(input.value){
			if(action.localeCompare("project_backup") == 0){
				requestProjectBackup(input.value);
			}else if(action.localeCompare("database_backup") == 0){
				requestDatabaseBackup(input.value);
			}else if(action.localeCompare("database_export") == 0){
				requestDatabaseExport(input.value);
			}else if(action.localeCompare("database_restoration") == 0){
				requestCheckData(input.value, adminToken, action);
			}else if(action.localeCompare("project_restoration") == 0){
				requestCheckData(input.value, adminToken, action);
			}
		}else{
			alert("You must specify a folder name !");
		}
	};

	window.onresize = function(){
		if(window.innerHeight <= 500){
			message.style.top = "0%";
		}else{
			message.style.top = "10%";
		}

		if(window.innerWidth <= 600){
			message.style.left = "0%";
			message.style.right = "0%";
		}else{
			message.style.left = "25%";
			message.style.right = "25%";
		}

		if(window.innerHeight <= 500){
			input.style.top = "55%";
		}else{ 
			input.style.top = "50%";
		}

		if(window.innerWidth <= 700){
			input.style.left = "15%";
			input.style.right = "15%";
			input.style.width = "70%";
		}else{
			input.style.left = "30%";
			input.style.right = "30%";
			input.style.width = "40%";
		}

		if(window.innerHeight <= 500){
			button.style.top = "80%";
		}else{
			button.style.top = "70%";
		}

		if(window.innerWidth <= 700){
			button.style.left = "30%";
			button.style.right = "30%";
			button.style.width = "40%";
		}else{
			button.style.left = "39%";
			button.style.right = "39%";
			button.style.width = "22%";
		}
	}

	view.appendChild(message);
	view.appendChild(input);
	view.appendChild(button);

	return view;
}

function requestProjectBackup(path){
	path = 'b'+path;
	var params = {
		"path":'\\' + path
	};
	params = JSON.stringify(params);
	var writer = document.getElementById("actviewer");
	writer.innerHTML = "";
	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var result = JSON.parse(this.responseText);
			if(result.message == "200"){
				var message = createMessageView("Project backup success ! <br/>Backup location is " + result.path + "\\.", "fa fa-check");
				writer.appendChild(message);
			}else{
				var message = createMessageView("Project backup failed ! <br/>An error occured during backup !<br/>", "fa fa-exclamation-triangle");
				writer.appendChild(message);	
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/projectBackup.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send(params);
}

function requestDatabaseBackup(path){
	path = 'b'+path;
	var params = {
		"path":'\\' + path
	};
	params = JSON.stringify(params);
	var writer = document.getElementById("actviewer");
	writer.innerHTML = "";
	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var result = JSON.parse(this.responseText);
			if(result.message == "200"){
				var message = createMessageView("Database backup success ! <br/>Backup location is " + result.path + "\\.", "fa fa-check");
				writer.appendChild(message);
			}else{
				var message = createMessageView("Database backup failed ! <br/>An error occured during backup !<br/>", "fa fa-exclamation-triangle");
				writer.appendChild(message);	
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/databaseBackup.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send(params);
}

function requestDatabaseExport(path){
	path = 'b'+path;
	var params = {
		"user":"1",
		"youtube" : "1",
		"instagram" : "1",
		"vimeo" : "1",
		"path":'\\' + path
	};
	params = JSON.stringify(params);
	var writer = document.getElementById("actviewer");
	writer.innerHTML = "";
	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var result = JSON.parse(this.responseText);
			if(result.message == "200"){
				var message = createMessageView("Database export CSV success ! <br/>CSV doc. location is " + result.path + "\\.", "fa fa-check");
				writer.appendChild(message);
			}else{
				var message = createMessageView("Database export CSV failed ! <br/>An error occured during backup !<br/>", "fa fa-exclamation-triangle");
				writer.appendChild(message);	
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/export.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send(params);
}

function requestDatabaseTables(){
	var writer = document.getElementById("strviewer");
	var view = createStructureViewer();
	var message = createCodeViewMessage("select a table...");
	writer.appendChild(view);
	var rightWriter = writer.children[0].children[1];
	var leftWriter = writer.children[0].children[0];
	rightWriter.appendChild(message);
	var row;

	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = JSON.parse(this.responseText);
			if(data.message == "200"){
				row = createDatabaseRow("Users", data.result.users);
				leftWriter.appendChild(row);
				row = createDatabaseRow("Youtube", data.result.youtube);
				leftWriter.appendChild(row);
				row = createDatabaseRow("Instagram", data.result.instagram);
				leftWriter.appendChild(row);
				row = createDatabaseRow("Vimeo", data.result.vimeo);
				leftWriter.appendChild(row);
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/getTables.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send();
}

function createDatabaseRow(table, data){
	
	var row = document.createElement("p");
	var code = document.createElement("div");

	for(var i=0;i<data.length;i++){
		var data_row = document.createElement("p");
		data_row.innerText = data[i];
		code.appendChild(data_row);
	}
	code.style.display = "none";
	var sentence = "<p><i class='fa fa-table'></i> " + table + " </p>";
	row.innerHTML = sentence;
	row.appendChild(code);
	
	row.style.color = "#101820FF";
	row.style.color = "black";
	row.style.fontFamily = "Times New Roman, Times, serif";


	row.onmouseover = function(){
		this.style.cursor = "pointer";
		this.style.color = "red";
	}

	row.onmouseout = function(){
		this.style.color = "#101820FF";
	}

	row.onclick = function(){
		var rightWriter = document.getElementById("codeView");
		var parent = this.parentNode;
		if(window.innerWidth <= 1200){
			if(parent.style.display = "block"){
				parent.style.display = "none";
				rightWriter.style.display = "block";
			}
		}
		rightWriter.innerHTML = "";
		rightWriter.innerHTML = this.children[1].innerHTML;
	}
	return row;
}

function restorationFolderChooser(action, text){
	var view = document.createElement("div");
	view.style.position = "absolute";
	view.style.top = "5%";
	view.style.bottom = "5%";
	view.style.left = "5%";
	view.style.right = "5%";
	view.style.textAlign = "center";

	var message = document.createElement("p");
	message.style.position = "absolute";
	if(window.innerHeight <= 500){
			message.style.top = "0%";
		}else{
			message.style.top = "7%";
		}

		if(window.innerWidth <= 600){
			message.style.left = "0%";
			message.style.right = "0%";
		}else{
			message.style.left = "20%";
			message.style.right = "20%";
		}
	message.style.fontSize = "25px";
	message.style.fontFamily = "Times New Roman, Times, serif";
	message.style.color = "#101820FF";
	message.innerHTML = "<p>" + text + "</p>";

	var input = document.createElement("input");
	input.setAttribute("type", "text");
	input.style.position = "absolute";
	if(window.innerHeight <= 500){
			input.style.top = "55%";
		}else{ 
			input.style.top = "50%";
		}

		if(window.innerWidth <= 700){
			input.style.left = "15%";
			input.style.right = "15%";
			input.style.width = "70%";
		}else{
			input.style.left = "30%";
			input.style.right = "30%";
			input.style.width = "40%";
		}
	input.style.height = "30px";
	input.style.border = "none";
	input.style.borderBottom = "2px solid #101820FF";
	input.style.paddingLeft = "2%";


	var button = document.createElement("button");
	button.innerHTML = "Submit";
	button.style.position = "absolute";
	if(window.innerHeight <= 500){
			button.style.top = "80%";
		}else{
			button.style.top = "70%";
		}

		if(window.innerWidth <= 700){
			button.style.left = "30%";
			button.style.right = "30%";
			button.style.width = "40%";
		}else{
			button.style.left = "39%";
			button.style.right = "39%";
			button.style.width = "22%";
		}
	button.style.height = "30px";
	button.style.border = "none";
	button.style.outline = "none";
	button.style.cursor = "pointer";
	button.style.background = "#101820FF";
	button.style.color = "#DAA03DFF"; 
	button.style.transition = "0.3s";
	window.onresize = function(){
		if(window.innerHeight <= 500){
			message.style.top = "0%";
		}else{
			message.style.top = "7%";
		}

		if(window.innerWidth <= 750){
			message.style.left = "0%";
			message.style.right = "0%";
		}else{
			message.style.left = "20%";
			message.style.right = "20%";
		}

		if(window.innerHeight <= 500){
			input.style.top = "58%";
		}else{ 
			input.style.top = "50%";
		}

		if(window.innerWidth <= 700){
			input.style.left = "15%";
			input.style.right = "15%";
			input.style.width = "70%";
		}else{
			input.style.left = "30%";
			input.style.right = "30%";
			input.style.width = "40%";
		}

		if(window.innerHeight <= 500){
			button.style.top = "80%";
		}else{
			button.style.top = "70%";
		}

		if(window.innerWidth <= 700){
			button.style.left = "30%";
			button.style.right = "30%";
			button.style.width = "40%";
		}else{
			button.style.left = "39%";
			button.style.right = "39%";
			button.style.width = "22%";
		}
	}


	button.onmouseover = function(){
		this.style.color = "#101820FF";
		this.style.background = "#DAA03DFF";
	}
	button.onmouseout = function(){
		this.style.background = "#101820FF";
		this.style.color = "#DAA03DFF"; 
	}

	button.onclick = function(){
		if(input.value){
			if(action.localeCompare("database_restoration") == 0){
				requestDatabaseRestoration(input.value);
			}else if(action.localeCompare("project_restoration") == 0){
				requestProjectRestoration(input.value);
			}
		}else{
			alert("You must select a backup folder !");
		}
	};

	view.appendChild(message);
	view.appendChild(input);
	view.appendChild(button);

	return view;
}

function requestDatabaseRestoration(path){
	var params = {
		"path" : "\\" + path
	};

	params = JSON.stringify(params);

	var writer = document.getElementById("actviewer");
	writer.innerHTML = "";
	var message;
	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = JSON.parse(this.responseText);
			if(data.message == "200"){
				message = createMessageView("Database restoration success !", "fa fa-check");
				writer.appendChild(message);
			}else{
				message = createMessageView("Database restoration error !<br>Make sure the name of folder is correct !", "fa fa-bell");
				writer.appendChild(message);
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/restoreDatabase.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send(params);
}

function requestProjectRestoration(path){

	var params = {
		"path" : "\\" + path
	};

	params = JSON.stringify(params);

	var writer = document.getElementById("actviewer");
	writer.innerHTML = "";
	var message;
	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = JSON.parse(this.responseText);
			if(data.message == "200"){
				message = createMessageView("Project restoration success !", "fa fa-check");
				writer.appendChild(message);
			}else{
				message = createMessageView("Project restoration error !<br>Make sure the name of folder is correct !", "fa fa-bell");
				writer.appendChild(message);
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/restoreProject.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send(params);
}


function requestCheckData(pass, token, action){
	var params = {
		"password" : pass,
		"token" : token
	};
	var view;
	var message;
	params = JSON.stringify(params);

	var writer = document.getElementById("actviewer");
	writer.innerHTML = "";
	var actionHttp = new XMLHttpRequest();
	actionHttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = JSON.parse(this.responseText);
			if(data.message == "200"){

					if(action == "database_restoration"){
						view = restorationFolderChooser(action, "Type the name of backup database folder.<br>Check admin/backup/database/.");
					}else{
						view = restorationFolderChooser(action, "Type the name of backup project folder.<br>Check admin/backup/project/.");
					}
					writer.appendChild(view);
			}else{
				message = createMessageView("Password incorrect !", "fa fa-bell");
				writer.appendChild(message);
			}
		}
	}

	actionHttp.open("POST", "http://localhost/project/sivir_api/api/admin/check.php", true);
	actionHttp.setRequestHeader("Content-type", "application/json");
	actionHttp.send(params);
}

function displaySelector(id){
	var writer = document.getElementById(id);
	var leftWriter = writer.children[0].children[0];
	var rightWriter = writer.children[0].children[1];
	rightWriter.style.display = "none";
	leftWriter.style.position = "absolute";
	leftWriter.style.left = "10%";
	leftWriter.style.right = "10%";
	leftWriter.style.display = "block";

}

function logOut(){

	window.location.assign("../admin/php/logout.php");
}