<!-- BEGIN FORMBLOCK -->

    <script language="javascript" type="text/javascript">
    function validateForm()
    {
    var x;
    var re;
        {{CODE}} 
    }
    </script>
    <form action="{{POSTPAGE}}" class="{{CLASS}}" method="post" enctype="multipart/form-data" name="StandardForm" id="{{UID}}" onsubmit="return validateForm()">
	{{CONTENT}}
    </form>

<!-- END FORMBLOCK -->

<!-- BEGIN TABLEBLOCK -->
    <fieldset class="form">
    <ol>
        {{CONTENT}}
    </ol>
     </fieldset>
<!-- END TABLEBLOCK -->

<!-- BEGIN FIELDS -->
    <label for="{{DBNAME}}"> {{FIELDNAME}} </label>
<!-- END FIELDS -->
<!-- BEGIN UNITBLOCK -->
<div class="unit">
            {{CONTENT}}
</div>
<!-- END UNITBLOCK -->
<!-- BEGIN ROWBLOCK -->
<li class="{{CLASS}}">
            {{CONTENT}}
</li>
<!-- END ROWBLOCK -->

<!-- BEGIN HIDDENFIELD -->
    <input type="hidden" name="{{NAME}}" value="{{VALUE}}" />
<!-- END HIDDENFIELD -->
<!-- BEGIN BUTTONBLOCK -->
     {{HIDDENFIELDS}}
    <input type="submit" />
<!-- END BUTTONBLOCK -->
<!-- BEGIN VALIDATION -->

 x=document.forms["StandardForm"]["b64{{CONTROLNAME}}"].value;
  re=/{{REGEX}}/;

  if (!re.test(x)) {
         alert("Veld {{FIELDNAME}} is niet juist ingevuld");
         return false;
      }

<!-- END VALIDATION -->


<!-- BEGIN PAGELIST -->
<ul id="pagination-digg">
    {{LIST}}
</ul> 
<!-- END PAGELIST -->

<!-- BEGIN PAGELINK -->
    <li class="{{CLASS}}"><a href="{{LINK}}">{{TEXT}}</a></li>
<!-- END PAGELINK -->
<!-- BEGIN PAGETEXT -->
    <li class="{{CLASS}}">{{TEXT}}</li>
<!-- END PAGETEXT -->
