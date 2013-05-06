<!-- BEGIN DELETE -->
<script LANGUAGE="JavaScript">
<!--
function confirmPost()
{
var agree=confirm("Are you sure you want to delete?");
if (agree)
return true ;
else
return false ;
}
// -->
</script>
        <a href="{{DELETEHANDLER}}?ID={{ID}}&type={{TYPE}}&pb={{PB}}"  onClick="return confirmPost()" > Delete </a>
<!-- END DELETE -->

