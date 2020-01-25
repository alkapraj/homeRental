function emptyFieldChk(form)
{
	var result 	  = 	emptyString(form.username.value,'Username')
	result 			+= 	emptyString(form.password.value,'Password')
	if(result!="") 
	{
		errAlert(result)
		return false;	//stop form from being submitted
	}	
}