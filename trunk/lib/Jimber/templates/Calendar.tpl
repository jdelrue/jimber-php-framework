<!-- BEGIN BROWSEBUTTONS -->
<div class="calendarBrowse"> <a href="{{PREV}}"><<</a> <span class="monthAndYear"> {{MONTH}} {{YEAR}} </span> <a href="{{NEXT}}">>></a> </div>
<!-- END BROWSEBUTTONS -->

<!-- BEGIN CALENDAR -->
{{MONTH}}
{{BROWSEBUTTONS}}
<table class="calendar" id="{{UID}}">
    <tr>
<th> Mo </th> <th> Tu </th> <th> Wed </th> <th> Thu </th> <th> Fri </th> <th> Sat </th> <th> Sun </th>
</tr>
{{ALLROWS}}
</table>
    
<!-- END CALENDAR -->
<!-- BEGIN LINK -->
<a href="{{LINK}}" {{EXTRA}}> {{TEXT}} </a>
<!-- END LINK -->

<!-- BEGIN TODAY -->
<td id="today"> <em> {{DAY}} </em> {{EVENTS}} </td>
<!-- END TODAY -->


<!-- BEGIN CALENDARCOL -->
<td> {{DAY}} {{EVENTS}} </td>
<!-- END CALENDARCOL -->
<!-- BEGIN CALENDARROW -->
<tr> {{ROW}} </tr>
<!-- END CALENDARROW -->

<!-- BEGIN EVENTBLOCK -->
<span class="{{CLASS}}"> {{EVENT}} </span>
<!-- END EVENTBLOCK -->

<!-- BEGIN LINKEDEVENTBLOCK -->
<a class="{{CLASS}}" href="{{LINK}}"> {{EVENT}} </a>
<!-- END LINKEDEVENTBLOCK -->