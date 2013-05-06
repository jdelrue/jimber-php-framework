<!-- BEGIN LOGINBLOCK -->
    <form action="{{POSTPAGE}}" method="post" enctype="multipart/form-data">
    <fieldset class="form">
       <ol>
        <li><label for="login"> Login </label>
        <input name="login" type="text" value="" /> </li>
        
            <li>   <label for="password"> Password </label>
            <input name="password" type="password" /></li>
            </ol>
     </fieldset>
    <input type="submit" class="button" value="Login"/>
    </form>
<!-- END LOGINBLOCK -->
<!-- BEGIN HIDDENFIELD -->
    <input type="hidden" name="{{NAME}}" value="{{VALUE}}" />
<!-- END HIDDENFIELD -->
