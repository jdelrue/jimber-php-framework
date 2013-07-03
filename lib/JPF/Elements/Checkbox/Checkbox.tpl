<!-- BEGIN TEXTFIELD -->
    <td>
        {{VALUE}}
    </td>
<!-- END TEXTFIELD -->
<!-- BEGIN CHECKBOX -->
        <input type="hidden" name="{{NAME}}UID" value="0" />
        <input class="checkbox" type="checkbox" name="{{NAME}}" value="{{VALUE}}" {{READONLY}} {{CHECKED}} {{DISABLED}} />
        {{ test }}
<!-- END CHECKBOX -->
<!-- BEGIN READONLY -->
onclick="return false"
<!-- END READONLY -->