
<li class="media well">
	<div class="media-body">
		<h4 class="media-heading"><?= $survey->getQuestion() ?></h4>
		<br>
	  <?
	  foreach ($survey->getResponses() as $response) { ?>
	 	<div class="fluid-row">
			<div class="span2"><?=$response->getTitle() ?></div>
			<div class="span2 progress progress-striped active">
				<div class="bar" style="width: <?=$response->getPercentage() ?>%"></div>
			</div>
			<span class="span1">(<?=$response->getPercentage() ?>%)</span>
			<form class="span1" method="post" action="<? echo $_SERVER['PHP_SELF'].'?action=Vote';?>">
				<input type="hidden" name="responseId" value="<?=$response->getId() ?>"> 
				<input type="submit" style="margin-left:5px" class="span1 btn btn-small btn-danger" value="Voter">
			</form>
		</div>
		<? } 
		?>
		
		<!--<div class="fluid-row">
			<div class="span2">Réponse 1</div>
			<div class="span2 progress progress-striped active">
				<div class="bar" style="width: 20%"></div>
			</div>
			<span class="span1">(20%)</span>
			<form class="span1" method="post" action="<? echo $_SERVER['PHP_SELF'].'?action=Vote';?>">
				<input type="hidden" name="responseId" value="1"> 
				<input type="submit" style="margin-left:5px" class="span1 btn btn-small btn-danger" value="Voter">
			</form>
		</div>

		<div class="fluid-row">
			<div class="span2">Réponse 2</div>
			<div class="span3 progress progress-striped active">
				<div class="bar" style="width: 80%"></div>
			</div>
			<span class="span1">(80%)</span>
			<form class="span1" method="post" action="<? echo $_SERVER['PHP_SELF'].'?action=Vote';?>">
				<input type="hidden" name="responseId" value="2"> 
				<input type="submit" style="margin-left:5px" class="span1 btn btn-small btn-danger" value="Voter">
			</form>
		</div>-->
		
	</div>
</li>



