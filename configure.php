<?php
require_once "../config.php";

use \Tsugi\Core\Cache;
use \Tsugi\Core\LTIX;

// Sanity checks
$LAUNCH = LTIX::requireData();
if ( ! $USER->instructor ) die("Requires instructor role");

// Model
$p = $CFG->dbprefix;

// View
$OUTPUT->header();
?>
<link rel="stylesheet" type="text/css" href="css/authoring.css">
<?php
$OUTPUT->bodyStart();
$OUTPUT->topNav();
echo('<span style="float: right; margin-bottom: 10px;">');
echo('<a href="index.php" class="btn btn-default">Cancel</a> ');
echo('<a href="old_configure.php" class="btn btn-default">Input GIFT Quiz Format</a> ');
echo('</span>');
$OUTPUT->flashMessages();
?>
<form method="post">
<div id="quiz_content"></div>
</form>
<select id="question_type_select">
  <option value=""> -- Add a New Question -- </option>
  <option value="true_false_question">True/False Question</option>
  <option value="multiple_choice_question">Multiple Choice/Multiple Answer Question</option>
  <option value="short_answer_question">Short Answer Question</option>
</select><br>
<input type="submit" value="Save">
<input type=submit name=doCancel onclick="location='<?php echo(addSession('index.php'));?>'; return false;" value="Cancel"></p>
<input type=submit name=view onclick="location='<?php echo(addSession('quiz_data.php'));?>'; return false;" value="View JSON"></p>
<?php
$OUTPUT->footer();
$OUTPUT->templateInclude(array('common', 'tf_authoring', 'mc_authoring', 'sa_authoring'));
?>
<script type="text/javascript" src="js/authoring.js"></script>
<script>

$(document).ready(()=> {
  // see if there's already a quiz saved in the JSON
  $.getJSON("<?= addSession('quiz_data.php') ?>", function(quizData) {
    if (!quizData) {
      console.log("No quiz is configured");
    } else {
      for (var q=0; q<quizData.length;q++) {
        var context = quizData[q];
        context.count = $("#quiz_content").children().length+1;
        addQuestion(context);
      }
    }
  });
})
</script>
