<div class="container">	
<br>
<br>
<br>
<div class="span7 offset2">
	<ul class="media-list">
		<?php
				foreach ($this->surveys as $survey) {
					$survey->computePercentages();
					require("survey.inc.php");
				}
		?>
	</ul>
</div>
</div>
