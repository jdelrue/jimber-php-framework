<!-- BEGIN TEXTFIELD -->
    <td>
        {{VALUE}}
    </td>
<!-- END TEXTFIELD -->
<!-- BEGIN CHECKBOX -->
        <input type="hidden" name="{{NAME}}" value="0"/>
        <input class="checkbox" type="checkbox" name="{{NAME}}" value="1" {{READONLY}} {{CHECKED}} {{DISABLED}} />
        {{ test }}
<!-- END CHECKBOX -->
<!-- BEGIN READONLY -->
onclick="return false"
<!-- END READONLY -->