<!-- BEGIN FORMBLOCK -->

    <form action={{ACTION}} method="post" enctype="multipart/form-data" onsubmit="return validateGrid()" name="rapidGrid" id="{{UID}}">
	{{CONTENT}}
    </form>
<!-- END FORMBLOCK -->

<!-- BEGIN TABLEBLOCK -->
    <span class="gridtitle">{{TITLE}} </span>
    <table class="grid" summary="Table with data from database. Table build by JPF" ID="{{ID}}">
        {{CONTENT}}
     </table>
<!-- END TABLEBLOCK -->
<!-- BEGIN FIELDS -->
    <th> {{FIELDNAME}} </th>
<!-- END FIELDS -->
<!-- BEGIN FIELDSLINKED -->
    <a href="{{PAGE}}"> {{FIELDNAME}} </a>
<!-- END FIELDSLINKED -->
<!-- BEGIN ROWBLOCK -->
    <tr class="{{ROWCLASS}}">

        {{CONTENT}}

    </tr>
<!-- END ROWBLOCK -->
<!-- BEGIN COLUMNBLOCK -->

    <td class="{{CLASS}}">
        {{CONTENT}}
    </td> 

<!-- END COLUMNBLOCK -->
<!-- BEGIN SUBGRID -->
    <tr>

        <td id="subGrid" class="{{SUBCLASS}}" colspan="{{FIELDS}}">
        {{CONTENT}}
         </td>
<!-- END SUBGRID -->
<!-- BEGIN LINKBR -->
<a href="{{LINK}}"> {{TEXT}} </a> <br />
<!-- END LINKBR -->

<!-- BEGIN LINK -->
<a href="{{LINK}}"> {{TEXT}} </a>
<!-- END LINK -->
<!-- BEGIN HIDDENFIELD -->
    <input type="hidden" name="{{NAME}}" value="{{VALUE}}" />
<!-- END HIDDENFIELD -->
<!-- BEGIN BUTTONBLOCK -->
     {{HIDDENFIELDS}}
    <input type="submit" ID="button" name="postbutton" />
<!-- END BUTTONBLOCK -->

<!-- BEGIN LINK -->
<a href="{{LINK}}"> {{TEXT}} </a>
<!-- END LINK -->
<!-- BEGIN LINKBR -->
<a href="{{LINK}}"> {{TEXT}} </a> <br />
<!-- END LINKBR -->
<!-- VALIDATION -->
    var x=document.forms["{{FORMNAME}}"]["CONTROLNAME"].value
    if (x==null || x=="")
      {{
      alert("First name must be filled out");
      return false;
      }}
<!-- END VALIDATION -->

<!-- BEGIN TEXT -->
{{TEXT}} 
<!-- END TEXT -->

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
