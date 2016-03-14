<h4>
    <div><strong>Student:</strong> <?php echo $info["first_name"] . " " . $info["last_name"]; ?></div>
    <div><strong>Average Score:</strong> <?php echo OutputFormat::formatScore($info["average_score"]); ?></div>
    <div><strong>Evaluations Taken:</strong> <?php echo $info["total_evaluations"]; ?></div>
</h4>

<br/>

<?php
$eNum = 1;
$qNum = 1;
$evaluation_id = null;
$finalScore = 0;
for ($i = 0; $i < count($list); $i++) {
    if ($list[$i]["evaluation_id"] != $evaluation_id) {
        echo "<div class='panel panel-primary'>";
        echo "  <div class='panel-heading'>Evaluation #{$eNum}</div>";
        echo "  <table class='table table-bordered table-striped table-hover'>";
        echo "      <thead>";
        echo "          <tr>";
        echo "              <th>QUESTION</th>";
        echo "              <th>COMMENT</th>";
        echo "              <th>SCORE</th>";
        echo "          </tr>";
        echo "      </thead>";
        echo "      <tbody>";
    }

    echo "          <tr>";
    echo "              <td>{$qNum}. {$list[$i]["question_name"]}</td>";
    echo "              <td>{$list[$i]["question_comment"]}</td>";
    echo "              <td>{$list[$i]["grade_score"]}</td>";
    echo "          </tr>";

    $finalScore += $list[$i]["grade_score"];

    if (($list[$i]["evaluation_id"] != @$list[$i + 1]["evaluation_id"]) || $i == count($list)) {
        echo "          <tr>";
        echo "              <td colspan='2'><strong>FINAL SCORE</strong></td>";
        echo "              <td><strong>" . OutputFormat::formatScore($finalScore) . "</strong></td>";
        echo "          </tr>";
        echo "      </tbody>";
        echo "  </table>";
        echo "</div>";
        $finalScore = 0;
        $eNum++;
    }

    $qNum++;
    $evaluation_id = $list[$i]["evaluation_id"];
}
