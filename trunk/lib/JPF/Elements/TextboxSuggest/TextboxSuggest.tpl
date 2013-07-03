<!-- BEGIN TEXTBOXSUGGEST -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    {{SCRIPT}}

 
<span class="ui-widget">
    <input name="{{NAME}}"  id="{{NAME}}"  type="text" value="{{VALUE}}" {{DISABLED}} /> {{STAR}} 
</span>
 <!-- END TEXTBOXSUGGEST -->
 
 <!-- BEGIN SUGGESTSCRIPT -->
 
 <script>
    $(function() {
        var availableTags = [
           {{VALUES}}
        ];
        $("#{{NAME}}").autocomplete({
            source: availableTags
        });
    });
    </script>
    
<!-- END SUGGESTSCRIPT -->