<!-- BEGIN SUREBLOCK -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
   <HEAD>
      <TITLE>Are you sure?</TITLE>
		
   </HEAD>
   <BODY>
    	<script LANGUAGE="JavaScript">
		<!--
		
		var agree=confirm("Are you sure?");
		if (!agree){
		history.go(-1)
                }else{
                       window.location = "{{REDIRECT}}";
                      
                }
                ;
		// -->
		</script>
                <p> If you are sure you want to perform this action click here: </p>
                <a href="{{REDIRECT}}"> Yes </a> 
   </BODY>
</HTML>
<!-- END SUREBLOCK -->
