<!-- BEGIN DATEBOX -->
<input name="{{NAME}}" type="text" value="{{VALUE}}" {{DISABLED}} /> {{STAR}} {{ADDTODAYLINK}}
<script lang="javascript">
    function addToday{{FUID}}()
{
    oFormObject = document.forms['{{UID}}'];
    var currentTime = new Date()
    var month = currentTime.getMonth() + 1
    var day = currentTime.getDate()
    var year = currentTime.getFullYear()

    oFormObject.elements["{{NAME}}"].value = day + "/" + month + "/" + year
}

    function addDate{{FUID}}(date)
{
    oFormObject = document.forms['{{UID}}'];


    oFormObject.elements["{{NAME}}"].value = date
}

</script>
<!-- END DATEBOX -->
<!-- BEGIN ADDTODAY -->
<span id="addDate">
<a onclick="addToday{{FUID}}()" href="javascript:void(0);"> <sub> Add today </sub> </a> &nbsp;
<a href="javascript:void(0);" onclick="window.open('{{DATEPICKER}}', 'Calendar', 'width=250, height=200, location=yes'); return false;"> <sub> Cal </sub> </a>
</span>
<!-- END ADDTODAY -->