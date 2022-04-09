<h2>Quiz Marking System</h2>
<form id="mcq_form">
<?php
if ( is_array( $value ) ) {
    echo "<div class='mark-options'>";
        foreach ( $value as $key => $item ) {
            echo "<p>{$item['title']}</p>";
            foreach ( $item['option'] as $list ) {
                echo "<p><input type='radio' name='ans[{$key}]' value='{$list}' > {$list} </p>";
            }
            echo "<input type='hidden' id='answer-{$key}' value='{$item['answer']}' />";
            echo '<br>';
        }
    echo '</div>';

} else {
    echo '<p>Not found</p>';
}
?>
<input type="submit" id="submit_result" value="Show Result" />
</form>
<div id="result_container"></div>