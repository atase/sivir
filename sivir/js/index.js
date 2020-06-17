
function displayRegister(){

	var register = document.getElementById("register_view");
	register.style.display = "block";
}

function displayLogin(){
	document.getElementById("login_view").style.display="block";
}

function hideRegister(){
	var register = document.getElementById("register_view");
	register.style.display = "none";

	var form = document.getElementById("register_form_id");
	form.reset();
}

function hideLogin(){
	document.getElementById("login_view").style.display = "none";;

	var form = document.getElementById("login_form_id");
	form.reset();
}

function hideNotification(notificationId){
	document.getElementById("notification_view").style.display="none";
	document.getElementById(notificationId).style.display="none";
}


function forgotPassword(){
	document.getElementById("forgot_password_view").style.display="block";
	document.getElementById("login_view").style.display="none";
}

function hideForgotPassword(){
	document.getElementById("forgot_password_view").style.display="none";	
}

function hidePasswordData(){
	document.getElementById("forgot_password_data").style.display = "none";
	var elem = document.getElementById("forgot_password_data")
	elem.children[0].style.display = "none";
	elem.children[1].style.display = "none";
}


function forgotPasswordView(){
	var email = document.getElementById("email_forgot_password").value;
	var birth = document.getElementById("birth_forgot_password").value;
	var name = document.getElementById("name_forgot_password").value;
	document.getElementById("forgot_password_view").style.display = "none";
	requestForgotPassword(email, birth, name);
}


function requestForgotPassword(email, birth, name){
	var params = {
		"email" : email,
		"firstSecurity" : birth,
		"secondSecurity" : name
	};

	params = JSON.stringify(params);
	var elem = document.getElementById("forgot_password_data")
	elem.style.display = "block";
	var writer = elem.children[0];
	var failed = elem.children[1];
	var paraghs = writer.getElementsByTagName("p");
	var forgotPass = new XMLHttpRequest();
	forgotPass.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var data = JSON.parse(this.responseText);
			if(data.message.localeCompare("200") == 0){
				paraghs[1].innerText = "username : " + data.username;
				paraghs[2].innerText = "password : " + data.password;
				writer.style.display = "block";
			}else{
         		failed.style.display = "block";
			}
		}
	} 

	forgotPass.open("POST", "http://localhost/project/sivir_api/api/user/forgotPassword.php", true);
	forgotPass.setRequestHeader("Content-type","application/json");
	forgotPass.send(params);

}